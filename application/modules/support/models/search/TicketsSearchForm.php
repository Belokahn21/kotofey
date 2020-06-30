<?php

namespace app\modules\support\models\search;

use app\modules\order\models\entity\Order;
use app\modules\catalog\models\entity\Product;
use app\modules\support\models\entity\Tickets;
use app\models\rbac\AuthItem;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class TicketsSearchForm extends Tickets
{

    public function rules()
    {
        return [
            [['id', 'status'], 'integer'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }
}