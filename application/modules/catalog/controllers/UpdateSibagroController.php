<?php

namespace app\modules\catalog\controllers;


use app\modules\catalog\models\entity\Offers;
use app\modules\catalog\models\form\OffersFromSibagoForm;
use app\modules\catalog\models\form\SibagroUploadForm;
use app\modules\catalog\models\helpers\OfferHelper;
use app\modules\site_settings\models\helpers\MarkupHelpers;
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
        $model = new SibagroUploadForm();
        $items = [];
        $productModelList = [];


        if (\Yii::$app->request->isPost) {

            if ($data = \Yii::$app->request->post('ProductFromSibagoForm')) {

                $markup = \Yii::$app->request->post('markup');
                $category_id = \Yii::$app->request->post('category_id');

                foreach ($data as $datum) {
                    if ($datum['skip'] == 1) continue;

                    $obj = new OffersFromSibagoForm();
                    $obj->scenario = OffersFromSibagoForm::SCENATIO_SIBAGRO_SAVE;
                    $obj->setAttributes($datum);


                    if ($markup) MarkupHelpers::applyMarkup($obj, $markup);
                    if ($category_id) $obj->category_id = $category_id;


                    if (Offers::findOneByCode($datum['code'])) {
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
                $productModelList[] = new \app\modules\catalog\models\form\OffersFromSibagoForm();
            }
        }

        return $this->render('upload', [
            'model' => $model,
            'items' => $items,
            'productModelList' => $productModelList
        ]);
    }
}