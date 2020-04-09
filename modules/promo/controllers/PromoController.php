<?php

namespace app\modules\promo\controllers;

use app\models\entity\InformersValues;
use app\models\entity\SlidersImages;
use app\modules\promo\models\form\PromoForm;
use app\widgets\notification\Alert;
use yii\web\Controller;

class PromoController extends Controller
{
    public $layout = '@app/views/layouts/admin';

    public function actionIndex()
    {
        $informerId = 10;
        $informerValueId = null;

        $model = new PromoForm();
        $sliderImageModel = new SlidersImages();
        $informerValuesModel = new InformersValues();


        if (\Yii::$app->request->isPost) {

            $transaction = \Yii::$app->db->beginTransaction();

            if ($informerValuesModel->load(\Yii::$app->request->post())) {
                if ($informerValuesModel->validate()) {
                    if ($informerValuesModel->save()) {
                        $informerValueId = $informerValuesModel->id;
                        $transaction->commit();
                    } else {
                        $transaction->rollBack();
                        Alert::setErrorNotify('Ошиба при создании значения информера');
                        return $this->refresh();
                    }
                } else {
                    $transaction->rollBack();
                    Alert::setErrorNotify('Ошиба при создании значения информера');
                    return $this->refresh();
                }
            }

            if ($sliderImageModel->load(\Yii::$app->request->post())) {
                if (empty($sliderImageModel->link)) {
                    $sliderImageModel->link = "/catalog/?CatalogFilter[informer][{$informerId}][]={$informerValueId}";
                }

                if ($sliderImageModel->validate()) {
                    if ($sliderImageModel->save()) {
//                        $transaction->commit();
                    } else {
                        $transaction->rollBack();
                        Alert::setErrorNotify('Ошиба при создании слайдера');
                        return $this->refresh();
                    }
                } else {
                    $transaction->rollBack();
                    Alert::setErrorNotify('Ошиба при создании слайдера');
                    return $this->refresh();
                }
            }

            if ($model->load(\Yii::$app->request->post())) {
                if ($model->validate()) {
                    if ($model->createPromo($informerValueId)) {
//                        $transaction->commit();
                    } else {
                        $transaction->rollBack();
                        Alert::setErrorNotify('Ошиба при применеии акции');
                        return $this->refresh();
                    }
                }
            }


            Alert::setSuccessNotify('Промоакция успешно запущена');
            return $this->refresh();
        }

        return $this->render('index', [
            'model' => $model,
            'sliderImageModel' => $sliderImageModel,
            'informerValuesForm' => $informerValuesModel,
        ]);
    }
}
