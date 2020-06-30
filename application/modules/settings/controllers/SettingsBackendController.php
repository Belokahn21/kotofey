<?php

namespace app\modules\settings\controllers;

use Yii;
use app\modules\site_settings\models\entity\SiteSettings;
use app\modules\site_settings\models\search\SettingsSearchForm;
use app\widgets\notification\Alert;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\UploadedFile;

class SettingsBackendController extends Controller
{
    public $layout = '@app/views/layouts/admin';

    public function actionIndex()
    {
        $model = new SiteSettings();
        $searchModel = new SettingsSearchForm();
        $dataProvider = $searchModel->search(Yii::$app->request->get());

        if (\Yii::$app->request->isPost) {
            if ($model->load(\Yii::$app->request->post())) {
                if ($model->validate()) {
                    if ($model->save()) {
                        Alert::setSuccessNotify("Настройки сохранены");
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
        $model = SiteSettings::findOne($id);

        if (!$model) {
            throw new HttpException(404, 'Такая настройка не существует');
        }

        if (\Yii::$app->request->isPost) {
            if ($model->load(\Yii::$app->request->post())) {
                if ($model->validate()) {
                    if ($model->update()) {
                        Alert::setSuccessNotify("Настройки обновлены");
                        return $this->redirect(Url::to(['update', 'id' => $model->id]));
                    }
                }
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }
}
