<?php

namespace app\modules\catalog\controllers;


use app\modules\catalog\models\entity\Product;
use app\modules\catalog\models\form\PriceUpdateForm;
use app\modules\catalog\models\helpers\ProductHelper;
use app\modules\site\controllers\MainBackendController;
use app\modules\site\models\tools\Debug;
use app\modules\vendors\models\entity\Vendor;
use yii\helpers\Html;
use yii\web\UploadedFile;

class PriceBackendController extends MainBackendController
{
    public function actionIndex()
    {
        $model = new PriceUpdateForm();
        $vendors = Vendor::find()->all();

        if (\Yii::$app->request->isPost) {
            if ($model->load(\Yii::$app->request->post())) {
                $vendor = Vendor::findOne($model->vendor_id);
                $upl = UploadedFile::getInstance($model, 'file');
                $empty_ids = [];
                $complete_ids = [];

                if (($handle = fopen($upl->tempName, "r")) !== false) {
                    while (($line = fgetcsv($handle, 1000, ";")) !== false) {
//                        Debug::p($line);

                        $code = $line[2];
                        $bad_price = $line[6];


                        if (empty($code) || mb_strlen($code) == 0) continue;

                        $bad_price = str_replace(' ', '', $bad_price);
                        $bad_price = str_replace(',', '.', $bad_price);
                        $bad_price = (float)$bad_price;


                        $base_price = round($bad_price);

                        Debug::p($base_price);


                        if ($product = Product::find()->where(['code' => $code, 'vendor_id' => $model->vendor_id])->one()) {
                            $product->scenario = Product::SCENARIO_UPDATE_PRODUCT;
                            $old_markup = ProductHelper::getMarkup($product);
                            $product->base_price = $base_price;

                            ProductHelper::makePurchase($product, $vendor);
                            ProductHelper::applyMarkup($product, $old_markup);

                            if ($product->validate()) {
//                            $product->update();
                                $complete_ids[] = $code;
                            }
                        } else {
                            $empty_ids[] = $code;
                        }
                    }
                }

//                Debug::p($complete_ids);
//                Debug::p($empty_ids);


//                foreach (Product::find()->where(['vendor_id' => $model->vendor_id])->all() as $item) {
//                    echo Html::tag('div', $item->name);
//                }
            }
        }

        return $this->render('index', [
            'model' => $model,
            'vendors' => $vendors,
        ]);
    }
}