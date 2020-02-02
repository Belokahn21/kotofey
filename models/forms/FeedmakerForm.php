<?php

namespace app\models\forms;


use yii\base\Model;

class FeedmakerForm extends Model
{
    public $attribute;
    public $feed;

    public function rules()
    {
        return [
            [['feed', 'attribute'], 'required'],

            [['feed'], 'string'],

            [['attribute'], 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'attribute' => 'Производитель',
            'feed' => 'Контент поиска',
        ];
    }
}