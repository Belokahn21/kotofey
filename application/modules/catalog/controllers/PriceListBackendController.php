<?php

namespace app\modules\catalog\controllers;

use app\modules\catalog\models\entity\Product;
use app\modules\catalog\models\form\PriceUpdateForm;
use app\modules\catalog\models\helpers\ProductHelper;
use app\modules\site\controllers\MainBackendController;
use app\modules\site\models\services\PriceListService;
use app\modules\site\models\tools\Debug;
use app\modules\site\models\tools\PriceTool;
use app\modules\site\models\tools\TmpFilePath;
use app\modules\vendors\models\entity\Vendor;
use PhpOffice\PhpSpreadsheet\IOFactory;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;

class PriceListBackendController extends MainBackendController
{
    public function actionIndex()
    {
        $all_list = [];
        $empty_list = [];
        $complete_list = [];
        $error_elements = [];
        $price_list_service = new PriceListService();

        $model = new PriceUpdateForm();
        $vendors = Vendor::find()->all();

        if (\Yii::$app->request->isPost) {
            if ($model->load(\Yii::$app->request->post())) {
                $vendor = Vendor::findOne($model->vendor_id);
                $upl = UploadedFile::getInstance($model, 'file');
                $csv_file_path = null;
                $all_list = Product::find()->where(['vendor_id' => $model->vendor_id]);

                if ($model->maker_id) {
                    $all_list->leftJoin('properties_product_values as ppv', 'ppv.product_id = product.id');
                    $all_list->andWhere(['ppv.value' => $model->maker_id]);
                }

                $all_list = $all_list->all();

                try {
                    $_reader = IOFactory::createReader('Xlsx');
                    $reader = $_reader->load($upl->tempName);
                    $writer = IOFactory::createWriter($reader, 'Csv');
                    $file_name = time() . '.csv';
                    $csv_file_path = TmpFilePath::buildFilePath($file_name);
                    $writer->save($csv_file_path);

                } catch (\Exception $exception) {
                    $csv_file_path = $upl->tempName;
                }


                if (file_exists($csv_file_path) && ($handle = fopen($csv_file_path, "r")) !== false) {
                    ini_set("memory_limit", "512M");
                    while (($line = fgetcsv($handle, 1000, $model->delimiter)) !== false) {
                        $code = ArrayHelper::getValue($line, $model->ident_key_col_id);
                        $_price = ArrayHelper::getValue($line, $model->price_col_id);
                        $base_price = null;
                        $purchase_price = null;
                        $product = null;


                        if (empty($code) || mb_strlen($code) == 0) continue;

                        $price = $price_list_service->normalize($model->type_price, $_price);

                        if ($price == 0) continue;

                        foreach ($all_list as $_product) {
                            if ($_product->code == $code) $product = $_product;
                        }

                        if ($product) {
                            $product->scenario = Product::SCENARIO_STOCK_COUNT;
                            $price_list_service->applyPrice($product, $model->type_price, $price, $vendor, (int)$model->default_markup, $model->force_markup);

                            if (!$product->validate()) {
                                $error_elements[] = $product;
                            }

                            if ($product->update() !== false) {
                                $complete_list[] = $product;
                            }
                        } else {
                            $empty_list[] = $code;
                        }
                    }
                }


            }
        }

        return $this->render('index', [
            'model' => $model,
            'vendors' => $vendors,
            'complete_ids' => $complete_list,
            'empty_ids' => $empty_list,
            'not_found' => $price_list_service->sortNotFound($all_list, $complete_list),
            'error_elements' => $error_elements,
        ]);
    }
}