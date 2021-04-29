<?php

namespace app\modules\pets\controllers;

use Yii;
use yii\web\Controller;
use yii\web\HttpException;
use app\widgets\notification\Alert;
use app\modules\pets\models\entity\Pets;

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
        if (!$model = Pets::findOne($id)) throw new HttpException(404, 'Элемент не найден.');

        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                if ($model->validate() && $model->save()) {
                    Alert::setSuccessNotify('Информация по питомцу успешно обновлена.');
                    return $this->refresh();
                }
            }
        }

        return $this->render('update', [
            'model' => $model
        ]);
    }

    public function actionDelete($id)
    {
        if (!$model = Pets::findOne($id)) throw new HttpException(404, 'Элемент не найден.');

        $model->status_id = Pets::STATUS_OFF;

        if ($model->hasOwner() && $model->update()) Alert::setSuccessNotify('Карточка питомца успешно удалена.');

        return $this->redirect(['/profile/']);
    }
}