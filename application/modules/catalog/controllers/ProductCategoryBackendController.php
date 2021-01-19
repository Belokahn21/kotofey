<?php

namespace app\modules\catalog\controllers;


use app\modules\catalog\models\entity\ProductCategory;
use app\modules\catalog\models\search\ProductCategorySearchForm;
use app\modules\site\controllers\MainBackendController;
use app\widgets\notification\Alert;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\HttpException;

class ProductCategoryBackendController extends MainBackendController
{
    public $layout = '@app/views/layouts/admin';

    public function actionIndex()
    {
        $model = new ProductCategory();
        $searchForm = new ProductCategorySearchForm();
        $dataProvider = $searchForm->search(\Yii::$app->request->get());

        if (\Yii::$app->request->isPost) {
            if ($model->load(\Yii::$app->request->post())) {
                if ($model->validate()) {
                    if ($model->save()) {
                        Alert::setSuccessNotify('Категория создана');
                        return $this->refresh();
                    }
                }
            }
        }

        return $this->render('index', [
            'model' => $model,
            'searchForm' => $searchForm,
            'categories' => $model->categoryTree(),
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = ProductCategory::findOne($id);
        if (!$model) {
            throw new HttpException(404, 'Раздел товара не существует');
        }

        if (\Yii::$app->request->isPost) {
            if ($model->load(\Yii::$app->request->post())) {
                if ($model->validate()) {
                    if ($model->save()) {
                        Alert::setSuccessNotify('Категория обновлена');
                        return $this->refresh();
                    }
                }
            }
        }

        return $this->render('update', [
            'model' => $model,
            'categories' => $model->categoryTree(),
        ]);
    }

    public function actionDelete($id)
    {
        if (ProductCategory::findOne($id)->delete()) {
            Alert::setSuccessNotify('Категория удалена');
        }

        return $this->redirect(Url::to(['index']));
    }
}