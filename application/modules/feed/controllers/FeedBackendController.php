<?php

namespace app\modules\feed\controllers;

use app\modules\feed\models\forms\ModifyProductForm;
use app\modules\feed\models\forms\SearchProductForm;
use app\modules\site\controllers\MainBackendController;
use app\widgets\notification\Alert;

class FeedBackendController extends MainBackendController
{
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
