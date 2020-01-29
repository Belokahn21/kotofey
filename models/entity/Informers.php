<?php

namespace app\models\entity;


use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;


/**
 * Informers model
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $slug
 * @property integer $sort
 * @property boolean $is_active
 * @property boolean $is_show_filter
 * @property integer $created_at
 * @property integer $updated_at
 */
class Informers extends ActiveRecord
{
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            [
                'class' => SluggableBehavior::className(),
                'attribute' => 'name',
                'ensureUnique' => true,
            ],
        ];
    }

    public function rules()
    {
        return [
            [['name'], 'required', 'message' => 'Поле {attribute} обязательно'],

            [['description'], 'string']
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Название',
            'sort' => 'Сортировка',
            'slug' => 'Символьный код',
            'description' => 'Описание',
            'id' => 'ID',
        ];
    }
}