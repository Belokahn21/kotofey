<?php

namespace app\modules\catalog\controllers;

use app\modules\site\models\tools\Debug;
use Yii;
use yii\helpers\Json;
use yii\web\Controller;
use yii\widgets\ActiveForm;
use app\models\tool\parser\ParseProvider;
use app\modules\catalog\models\entity\NotifyAdmission;

class AjaxController extends Controller
{
    public function actionCatalogFillFromVendor()
    {
        $data = \Yii::$app->request->post();

        $factory = new ParseProvider($data['link']);
        $factory->contract();

        return Json::encode($factory->getInfo());
    }
}