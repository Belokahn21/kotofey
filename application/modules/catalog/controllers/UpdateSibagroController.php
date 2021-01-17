<?php

namespace app\modules\catalog\controllers;


use app\modules\catalog\models\entity\Product;
use app\modules\catalog\models\form\ProductFromSibagoForm;
use app\modules\catalog\models\form\SibagroUpload;
use app\modules\site\controllers\MainBackendController;
use app\modules\site\models\tools\Debug;
use yii\web\Controller;

class UpdateSibagroController extends MainBackendController
{


    public function behaviors()
    {
        $parentAccess = parent::behaviors();
        $oldRules = $parentAccess['access']['rules'];
        $newRules = [['allow' => true, 'actions' => ['upload'], 'roles' => ['Administrator']]];


        $parentAccess['access']['rules'] = array_merge($newRules, $oldRules);

        return $parentAccess;
    }
    public function actionUpload()
    {
        $model = new SibagroUpload();
        $items = [];
        $productModelList = [];


        if (\Yii::$app->request->isPost) {

            if ($data = \Yii::$app->request->post('ProductFromSibagoForm')) {
                foreach ($data as $datum) {
                    $obj = new ProductFromSibagoForm();
                    $obj->scenario = ProductFromSibagoForm::SCENATIO_SIBAGRO_SAVE;
                    $obj->setAttributes($datum);
                    if (Product::findOneByCode($datum['code'])) {
                        if (!$obj->validate() || !$obj->update()) {
                            Debug::p($obj->getErrors());
                        }
                    } else {
                        if (!$obj->validate() || !$obj->save()) {
                            Debug::p($obj->getErrors());
                        }
                    }
                }
            }

            if ($model->load(\Yii::$app->request->post())) {
                $items = $model->parse();
            }

            for ($i = 0; $i < sizeof($items); $i++) {
                $productModelList[] = new \app\modules\catalog\models\form\ProductFromSibagoForm();
            }
        }

        return $this->render('upload', [
            'model' => $model,
            'items' => $items,
            'productModelList' => $productModelList
        ]);
    }
}