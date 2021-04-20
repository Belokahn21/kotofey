<?php

namespace app\modules\media\controllers;


use yii\rest\ActiveController;

class RestBackendController extends ActiveController
{
    public $modelClass = 'app\modules\media\models\entity\Media';
}