<?php
/**
 * Developer: Konstantin Vasin by PhpStorm
 * Company: Altasib
 * Time: 19:51
 */

namespace app\modules\rest\controllers;


use app\modules\catalog\models\entity\ProductCategory;
use yii\helpers\Json;
use yii\web\Controller;

class CategoryController extends Controller
{
    const ERROR_CODE = 400;
    const SUCCESS_CODE = 200;

    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionThree()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return Json::encode([
            (new ProductCategory())->categoryTree()
        ]);
    }
}