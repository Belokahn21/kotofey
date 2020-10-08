<?php

namespace app\modules\site_settings\controllers;

use yii\web\Controller;

/**
 * Default controller for the `site_settings` module
 */
class DefaultController extends Controller
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
