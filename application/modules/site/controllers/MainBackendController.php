<?php

namespace app\modules\site\controllers;


use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

class MainBackendController extends Controller
{
    public $layout = '@app/views/layouts/admin';
    public $modelClass;

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    ['allow' => true, 'actions' => ['index', 'update'], 'roles' => ['Administrator', 'Developer', 'SaleManager','Content']],
                    ['allow' => true, 'actions' => ['delete'], 'roles' => ['Administrator']],
                    ['allow' => false],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }
}