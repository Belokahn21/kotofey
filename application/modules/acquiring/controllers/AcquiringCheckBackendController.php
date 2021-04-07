<?php


namespace app\modules\acquiring\controllers;

use app\modules\acquiring\models\search\AcquiringOrderCheckSearch;
use app\modules\site\controllers\MainBackendController;
use yii\web\HttpException;
use Yii;

class AcquiringCheckBackendController extends MainBackendController
{
    public $modelClass = 'app\modules\acquiring\models\entity\AcquiringOrderCheck';

    public function actionIndex()
    {
        $searchModel = new AcquiringOrderCheckSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->get());

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionUpdate($id)
    {
        if (!$model = $this->modelClass::findOne($id)) throw new HttpException(404, 'Элемент не найден');
        return $this->render('update');
    }
}