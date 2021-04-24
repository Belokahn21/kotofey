<?php

namespace app\modules\pets\controllers;

use yii\web\Controller;
use app\modules\pets\models\entity\Pets;
use app\widgets\notification\Alert;

class PetController extends Controller
{
    public function actionCreate()
    {
        $model = new Pets();
        if (\Yii::$app->request->isPost) {
            if ($model->load(\Yii::$app->request->post())) {
                if ($model->validate() && $model->save()) {
                    Alert::setSuccessNotify('Карточка петомца успешно добавлена');
                    return $this->refresh();
                }
            }
        }
    }
}