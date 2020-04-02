<?php

namespace app\modules\feed\controllers;

use app\modules\feed\models\forms\ModifyProductForm;
use app\modules\feed\models\forms\SearchProductForm;
use app\widgets\notification\Alert;
use yii\web\Controller;

class FeedController extends Controller
{
    public $layout = '@app/views/layouts/admin';

    public function actionIndex()
    {
        $products = array();
        $searchProductModel = new SearchProductForm();
        $modifyProductModel = new ModifyProductForm();

        if (\Yii::$app->request->isPost) {
            if ($searchProductModel->load(\Yii::$app->request->post())) {
                if ($searchProductModel->validate()) {
                    $products = $searchProductModel->search();
                }
            }

            if ($modifyProductModel->load(\Yii::$app->request->post())) {
                if ($modifyProductModel->validate()) {
                    if (!$modifyProductModel->modify($products)) {
                        Alert::setErrorNotify('Ошибка при обновлении товаров');
                        return $this->refresh();
                    }

                    $modifyProductModel->clearModel();
                }
            }
        }

        return $this->render('index', [
            'searchProductModel' => $searchProductModel,
            'modifyProductModel' => $modifyProductModel,
            'products' => $products,
        ]);
    }
}
