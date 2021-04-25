<?php

namespace app\modules\pets\controllers;

use app\modules\site\models\tools\Debug;
use yii\web\Controller;
use app\modules\pets\models\entity\Pets;
use app\widgets\notification\Alert;
use yii\web\HttpException;

class PetController extends Controller
{
    public function actionCreate()
    {
        $model = new Pets();
        if (\Yii::$app->request->isPost) {
            if ($model->load(\Yii::$app->request->post())) {
                if ($model->validate() && $model->save()) {
                    Alert::setSuccessNotify('Карточка питомца успешно добавлена');
                }
            }
        }
        return $this->redirect(['/profile']);
    }

    public function actionUpdate($id)
    {
        return $this->render('update');
    }

    public function actionDelete($id)
    {
        if (!$model = Pets::findOne($id)) throw new HttpException(404, 'Элемент не найден.');

        $model->status_id = Pets::STATUS_OFF;

        if ($model->hasOwner() && $model->update()) Alert::setSuccessNotify('Карточка питомца успешно удалена.');

        return $this->redirect(['/profile/']);
    }
}