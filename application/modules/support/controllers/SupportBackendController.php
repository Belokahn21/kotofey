<?php

namespace app\modules\support\controllers;

use app\models\entity\support\Tickets;
use app\modules\support\models\search\TicketSearchForm;
use yii\web\Controller;

class SupportBackendController extends Controller
{
    public $layout = '@app/views/layouts/admin';

    public function actionIndex()
    {
        $model = new Tickets();
        $searchModel = new TicketSearchForm();
        $dataProvider = $searchModel->search(\Yii::$app->request->get());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }
}
