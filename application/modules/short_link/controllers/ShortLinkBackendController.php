<?php

namespace app\modules\short_link\controllers;

use Yii;
use app\models\entity\ShortLinks;
use app\models\search\ShortLinksSearchModel;
use app\widgets\notification\Alert;
use yii\web\Controller;
use yii\web\HttpException;

class ShortLinkBackendController extends Controller
{
    public $layout = '@app/views/layouts/admin';

    public function actionIndex()
    {
        $model = new ShortLinks();
        $searchModel = new ShortLinksSearchModel();
        $dataProvider = $searchModel->search(Yii::$app->request->get());


        if (\Yii::$app->request->isPost) {
            if ($model->load(\Yii::$app->request->post())) {
                if ($model->validate()) {
                    if ($model->save()) {
                        Alert::setSuccessNotify('Короткая ссылка успешно добавлена');
                        return $this->refresh();
                    }
                }
            }
        }


        return $this->render('index', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = ShortLinks::findOne($id);

        if (!$model) {
            throw new HttpException(404, 'Запись не найдена');
        }

        if (\Yii::$app->request->isPost) {
            if ($model->load(\Yii::$app->request->post())) {
                if ($model->validate()) {
                    if ($model->update()) {
                        Alert::setSuccessNotify('Короткая ссылка успешно обновлена');
                        return $this->refresh();
                    }
                }
            }
        }

        return $this->render('update', [
            'model' => $model
        ]);
    }

    public function actionDelete($id)
    {
        if (ShortLinks::findOne($id)->delete()) {
            Alert::setSuccessNotify('Короткая ссылка удалена');
        }
        return $this->redirect(['index']);
    }
}
