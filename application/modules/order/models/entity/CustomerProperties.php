<?php

namespace app\modules\order\models\entity;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "customer_properties".
 *
 * @property int $id
 * @property int|null $is_active
 * @property int|null $sort
 * @property string|null $name
 * @property string|null $cross
 * @property int|null $created_at
 * @property int|null $updated_at
 */
class CustomerProperties extends \yii\db\ActiveRecord
{
    public function behaviors()
    {
        return [
            TimestampBehavior::className()
        ];
    }

    public function rules()
    {
        return [
            [['is_active'], 'default', 'value' => true],

            [['sort'], 'default', 'value' => 500],

            [['is_active', 'sort', 'created_at', 'updated_at'], 'integer'],

            [['name', 'cross'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'is_active' => 'Активность',
            'sort' => 'Сортировка',
            'name' => 'Название',
            'cross' => 'Свойство в заказе',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
        ];
    }
}
