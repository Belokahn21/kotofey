<?php

namespace app\models\search;

use app\models\entity\Product;
use app\models\entity\User;
use app\models\rbac\AuthItem;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class UserSearchForm extends User
{

    public static function tableName()
    {
        return "user";
    }

    public function rules()
    {
        return [
            [['email'], 'string'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

}