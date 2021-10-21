<?php

namespace app\modules\order\widgets\GroupBuy;


use app\modules\order\models\entity\Customer;
use app\modules\order\models\entity\Order;
use app\modules\order\models\entity\OrdersItems;
use app\modules\order\models\service\GroupBuyDataService;
use yii\base\Widget;

class GroupBuyWidget extends Widget
{
    public $view = 'default';

    public function run()
    {
        $groupedData = GroupBuyDataService::getInstance()->load_data();

        return $this->render($this->view, [
            'groupedData' => $groupedData
        ]);
    }

}