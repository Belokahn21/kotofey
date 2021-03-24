<?php


namespace app\modules\acquiring\controllers;

use Yii;
use yii\web\HttpException;
use app\modules\acquiring\models\forms\AcquiringForm;
use app\modules\site\controllers\MainBackendController;
use app\modules\acquiring\models\search\AcquiringOrderSearch;

class AcquiringBackendController extends MainBackendController
{
    public $modelClass = 'app\modules\acquiring\models\entity\AcquiringOrder';

    public function actionIndex()
    {
        $searchModel = new AcquiringOrderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->get());


        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionUpdate($id)
    {
        if (!$model = $this->modelClass::findOne($id)) throw new HttpException(404, 'Элемент не найден');

        $actionForm = new AcquiringForm();


        if (Yii::$app->request->isPost) {
            if ($actionForm->load(Yii::$app->request->post())) {
                if ($actionForm->validate() && $actionForm->doAction()) {
                }
            }
        }


        return $this->render('update', [
            'model' => $model,
            'actionForm' => $actionForm
        ]);
    }
}