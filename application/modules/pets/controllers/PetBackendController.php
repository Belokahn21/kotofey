<?php


namespace app\modules\pets\controllers;


use app\modules\pets\models\entity\Pets;
use app\modules\pets\models\search\PetsSearchForm;
use app\modules\site\controllers\MainBackendController;

class PetBackendController extends MainBackendController
{
    public function actionIndex()
    {
        $model = new Pets();
        $searchModel = new PetsSearchForm();
        $dataProvider = $searchModel->search(\Yii::$app->request->get());


        return $this->render('index', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionUpdate($id)
    {
        return $this->render('update');
    }

    public function actionDelete($id)
    {
    }
}