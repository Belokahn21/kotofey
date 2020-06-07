<?php
/**
 * Developer: Konstantin Vasin by PhpStorm
 * Company: Altasib
 * Time: 10:42
 */

namespace app\modules\news\controllers;


use app\models\entity\NewsCategory;
use app\models\search\NewsCategorySearchForm;
use app\widgets\notification\Alert;
use yii\web\Controller;
use yii\web\HttpException;

class NewsCategoryBackendController extends Controller
{
    public $layout = '@app/views/layouts/admin';

    public function actionIndex()
    {
        $model = new NewsCategory();
        $searchModel = new NewsCategorySearchForm();
        $dataProvider = $searchModel->search(\Yii::$app->request->get());

        if (\Yii::$app->request->isPost) {
            if ($model->load(\Yii::$app->request->post())) {
                if ($model->validate()) {
                    if ($model->save()) {
                        Alert::setSuccessNotify('Рубрика создана');
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
        $model = NewsCategory::findOne($id);
        if (!$model) {
            throw new HttpException(404, 'Запись не найдена');
        }

        if (\Yii::$app->request->isPost) {
            if ($model->load(\Yii::$app->request->post())) {
                if ($model->validate()) {
                    if ($model->update()) {
                        Alert::setSuccessNotify('Рубрика обновлена');
                        return $this->refresh();
                    }
                }
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        if (NewsCategory::findOne($id)->delete()) {
            Alert::setSuccessNotify('Категория новости удалена');
        }

        return $this->redirect(['index']);
    }
}