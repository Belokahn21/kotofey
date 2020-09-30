<?php

namespace app\modules\catalog\console;

use app\models\tool\parser\ParseProvider;
use app\models\tool\parser\providers\SibagroTrade;
use app\modules\catalog\models\entity\Product;
use app\modules\catalog\models\entity\ProductSync;
use app\modules\logger\models\entity\Logger;
use app\modules\vendors\models\entity\Vendor;
use yii\console\Controller;
use yii\helpers\ArrayHelper;

class SibagroController extends Controller
{
    const VENDOR_SIBAGRO_ID = 4;
    const UNIQ_LOG_CODE = 'sibagro_upload';

    public function actionUpdate()
    {
        $log = new Logger();
        $products = Product::find()->where(['vendor_id' => self::VENDOR_SIBAGRO_ID])->limit(500);

        if ($alreadySync = ProductSync::find()->all()) {
            $products->andWhere(['<>', 'id', ArrayHelper::getColumn($alreadySync, 'product_id')]);
        }

        $products = $products->all();

        if (!$products) {
            $log->saveMessage("При синхронизации товаров с поставщиком " . Vendor::findOne(self::VENDOR_SIBAGRO_ID)->name . " возникла ошибка. Найдено товаров: 0", self::UNIQ_LOG_CODE);
        }

        foreach ($products as $product) {
            $oldProduct = clone $product;
            $logger = new Logger();

            $productUrl = SibagroTrade::getProductDetailByCode($product->code);
            $oldPercent = floor((($product->price - $product->purchase) / $product->purchase) * 100);

            $provider = new ParseProvider($productUrl);
            $provider->contract();

            try {
                $virProduct = $provider->getInfo();
            } catch (\Exception $exception) {
                $logger->saveMessage("Ошибка получения данных у товара с кодом {$product->code} . Ошибка: " . $exception->getMessage(), self::UNIQ_LOG_CODE);
            }

            $product->scenario = Product::SCENARIO_UPDATE_PRODUCT;
            $product->status_id = $virProduct->status_id;
            $product->purchase = $virProduct->purchase;
            $product->price = $product->purchase + floor($product->purchase * $oldPercent / 100);

            if (!$product->validate()) {
                $logger->saveMessage("Товар ID: {$product->id} - {$product->name} не обновлён. Ошибка валидации товара. Товар не обновлён.", self::UNIQ_LOG_CODE);
                return false;
            }

            if (!$product->update()) {
                $logger->saveMessage("Товар ID: {$product->id} - {$product->name} не обновлён. Ошибка обновления товара. Товар не обновлён.", self::UNIQ_LOG_CODE);
                return false;
            }

            $logger->saveMessage("Товар ID: {$product->id} - {$product->name} обновлён.\n\rСтатус: {$oldProduct->status_id}=>{$product->status_id}\n\rСтарая цена:{$oldProduct->price}=>{$product->price}", self::UNIQ_LOG_CODE);


            // сохраним товар чтобы повторно не проверять последние 7 дней
            $obj = new ProductSync();
            $obj->product_id = $product->id;
            $obj->last_run_at = time();

            if (!$obj->validate()) {
                $logger->saveMessage("У товара ID: {$product->id} - {$product->name} не сохранился учёт проверки. Ошибка валидации.", self::UNIQ_LOG_CODE);
            }
            if (!$obj->save()) {
                $logger->saveMessage("У товара ID: {$product->id} - {$product->name} не сохранился учёт проверки. Ошибка сохранения.", self::UNIQ_LOG_CODE);
            }
        }

        return true;
    }
}