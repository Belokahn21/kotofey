<?php

namespace app\modules\order\controllers;


use yii\rest\ActiveController;

class CustomerRestBackendController extends ActiveController
{
    public $modelClass = 'app\modules\order\models\entity\Customer';

}