<?php
/**
 * Developer: Konstantin Vasin by PhpStorm
 * Company: Altasib
 * Time: 10:42
 */

namespace app\modules\news\controllers;


use yii\web\HttpException;
use app\widgets\notification\Alert;
use app\modules\news\models\search\NewsCategorySearchForm;
use app\modules\site\controllers\MainBackendController;

class NewsCategoryBackendController extends MainBackendController
{
    public $modelClass = 'app\modules\news\models\entity\NewsCategory';

    public function actionIndex()
    {
        $model = new $this->modelClass();
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
        if (!$model = $this->getModel($id)) throw new HttpException(404, 'Элемент не найден');

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
        if (!$model = $this->getModel($id)) throw new HttpException(404, 'Элемент не найден');

        if ($model->delete()) Alert::setSuccessNotify('Категория новости удалена');

        return $this->redirect(['index']);
    }

    private function getModel($id)
    {
        return $this->modelClass::findOne($id);
    }
}