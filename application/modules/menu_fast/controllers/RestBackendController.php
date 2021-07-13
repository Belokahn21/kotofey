<?php

namespace app\modules\menu_fast\controllers;

use app\modules\catalog\models\entity\Offers;
use app\modules\order\models\entity\Order;
use yii\filters\Cors;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\rest\Controller;

class RestBackendController extends Controller
{
    public $modelClass = 'app\modules\promocode\models\entity\Promocode';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['corsFilter'] = [
            'class' => Cors::className()
        ];
        return $behaviors;
    }

    protected function verbs()
    {
        return [
            'index' => ['GET'],
        ];
    }

    public function actionIndex()
    {
        $start = new \DateTime();
        $start->setTime(0, 0, 0);
        $end = new \DateTime();
        $end->setTime(23, 59, 59);

        $menu = [
            [
                'icon' => 'fa-receipt',
                'href' => Url::to(['/admin/order/order-backend/index']),
                'isNewData' => (Order::find()->where([
                        'and',
                        ['>', 'created_at', $start->getTimestamp()],
                        ['<', 'created_at', $end->getTimestamp()],
                    ])->count()) > 0
            ],
            [
                'icon' => 'fa-cubes',
                'href' => Url::to(['/admin/catalog/product-backend/index']),
                'isNewData' => (Offers::find()->where([
                        'and',
                        ['>', 'created_at', $start->getTimestamp()],
                        ['<', 'created_at', $end->getTimestamp()],
                    ])->count()) > 0
            ],
            [
                'icon' => 'fas fa-truck',
                'href' => Url::to(['/admin/logistic/route-backend/index']),
                'isNewData' => false
            ],
        ];

        return Json::encode($menu);
    }
}
