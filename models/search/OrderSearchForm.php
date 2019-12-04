<?php

namespace app\models\search;

use app\models\entity\Order;
use app\models\entity\Product;
use app\models\rbac\AuthItem;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class OrderSearchForm extends Order
{

    public function rules()
    {
        return [
            [['delivery', 'payment'], 'string'],
            [['paid', 'user'], 'integer'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }


}