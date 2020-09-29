<?php

namespace app\modules\catalog\console;

use app\models\tool\Debug;
use app\models\tool\parser\ParseProvider;
use app\models\tool\parser\providers\SibagroTrade;
use app\modules\catalog\models\entity\Product;
use app\modules\logger\models\entity\Logger;
use app\modules\vendors\models\entity\Vendor;
use yii\console\Controller;

class SibagroController extends Controller
{
    const VENDOR_SIBAGRO_ID = 4;

    private $logger;

    public function __construct($id, $module, $config = [])
    {
        parent::__construct($id, $module, $config);

        $this->logger = new Logger();
    }

    public function actionUpdate()
    {
        $products = Product::find()->where(['vendor_id' => self::VENDOR_SIBAGRO_ID])->limit(5)->all();

        if (!$products) {
            $this->logger->message = "При синхронизации товаров с поставщиком " . Vendor::findOne(self::VENDOR_SIBAGRO_ID)->name . " возникла ошибка. Найдено товаров: 0";
        }

        foreach ($products as $product) {
            $productUrl = SibagroTrade::getProductDetailByCode($product->code);
            $provider = new ParseProvider($productUrl);
            $provider->contract();
            $virProduct = $provider->getInfo();
            var_dump($virProduct);



        }
    }
}