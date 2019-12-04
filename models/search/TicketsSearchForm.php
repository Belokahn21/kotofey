<?php

namespace app\models\search;

use app\models\entity\Order;
use app\models\entity\Product;
use app\models\entity\support\Tickets;
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