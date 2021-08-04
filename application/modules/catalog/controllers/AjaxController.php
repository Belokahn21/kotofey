<?php

namespace app\modules\catalog\controllers;

use yii\helpers\Json;
use yii\web\Controller;
use app\models\tool\parser\ParseProvider;
use app\modules\site\models\tools\Currency;
use app\modules\site\models\tools\PriceTool;
use app\modules\basket\models\entity\Basket;

class AjaxController extends Controller
{
    public function actionCatalogFillFromVendor()
    {
        $data = \Yii::$app->request->post();

        $factory = new ParseProvider($data['link']);
        $factory->contract();

        return Json::encode($factory->getInfo());
    }

    public function actionGetMiniCartAmount()
    {
        return Json::encode([
            'text' => PriceTool::format(Basket::getInstance()->cash()) . Currency::getInstance()->show()
        ]);
    }

    public function actionGetMiniCartCount()
    {
        return Json::encode([
            'text' => \Yii::t('app', '{n, plural, =0{позиций} =1{позиций} one{# позиций} few{# позиций} many{# позиций} other{# позиции}}', ['n' => Basket::count()])
        ]);
    }
}