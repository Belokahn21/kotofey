<?php

namespace app\modules\compare\controllers;

use yii\web\Controller;

/**
 * Default controller for the `compare` module
 */
class CompareController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
