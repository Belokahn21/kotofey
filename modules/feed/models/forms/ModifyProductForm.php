<?php

namespace app\modules\feed\models\forms;


use yii\base\Model;

class ModifyProductForm extends Model
{
    public $products;
    public $feed;

    public function rules()
    {
        return [
            ['feed', 'string'],
            ['products', 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'feed' => 'Поисковой контент'
        ];
    }
}