<?php

namespace app\modules\catalog\controllers;


use app\modules\catalog\models\entity\Product;
use app\modules\catalog\models\form\PriceUpdateForm;
use app\modules\catalog\models\helpers\ProductHelper;
use app\modules\site\controllers\MainBackendController;
use app\modules\site\models\tools\Price;
use app\modules\vendors\models\entity\Vendor;
use yii\web\UploadedFile;

class PriceBackendController extends MainBackendController
{
    public function actionIndex()
    {
        $empty_ids = [];
        $complete_ids = [];
        $error_elements = [];

        $model = new PriceUpdateForm();
        $vendors = Vendor::find()->all();

        if (\Yii::$app->request->isPost) {
            if ($model->load(\Yii::$app->request->post())) {
                $vendor = Vendor::findOne($model->vendor_id);
                $upl = UploadedFile::getInstance($model, 'file');


                if (($handle = fopen($upl->tempName, "r")) !== false) {
                    while (($line = fgetcsv($handle, 1000, $model->delimiter)) !== false) {
                        $code = $line[2];
                        $bad_price = $line[6];
                        $base_price = null;
                        $purchase_price = null;


                        if (empty($code) || mb_strlen($code) == 0) continue;

                        if ($vendor->type_price == Vendor::TYPE_PRICE_BASE) {
                            $base_price = Price::normalize($bad_price);
                        }

                        if ($vendor->type_price == Vendor::TYPE_PRICE_PURCHASE) {
                            $purchase_price = Price::normalize($bad_price);
                        }


                        if ($product = Product::find()->where(['code' => $code, 'vendor_id' => $model->vendor_id])->one()) {
                            $product->scenario = Product::SCENARIO_STOCK_COUNT;
                            $old_markup = ProductHelper::getMarkup($product, intval($model->default_markup));

                            if ($vendor->type_price == Vendor::TYPE_PRICE_BASE) {
                                $product->base_price = $base_price;
                                ProductHelper::makePurchase($product, $vendor);
                                ProductHelper::applyMarkup($product, $old_markup);
                            }

                            if ($vendor->type_price == Vendor::TYPE_PRICE_PURCHASE) {
                                $product->purchase = $purchase_price;
                                ProductHelper::applyMarkup($product, $old_markup);
                            }


                            if (!$product->validate()) {
                                $error_elements[] = $product;
                            }


                            if ($product->update() !== false) {
                                $complete_ids[] = $product;
                            }
                        } else {
                            $empty_ids[] = $code;
                        }
                    }
                }


            }
        }

        return $this->render('index', [
            'model' => $model,
            'vendors' => $vendors,
            'complete_ids' => $complete_ids,
            'empty_ids' => $empty_ids,
            'error_elements' => $error_elements,
        ]);
    }
}