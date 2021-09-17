<?php

namespace app\modules\order\models\entity;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "customer_status".
 *
 * @property int $id
 * @property int|null $is_active
 * @property int|null $sort
 * @property string|null $name
 * @property int|null $created_at
 * @property int|null $updated_at
 */
class CustomerStatus extends \yii\db\ActiveRecord
{
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    public function rules()
    {
        return [
            ['is_active', 'default', 'value' => 1],

            ['sort', 'default', 'value' => 500],

            [['is_active', 'sort', 'created_at', 'updated_at'], 'integer'],

            [['name'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'is_active' => "Активность",
            'sort' => 'Сортировка',
            'name' => 'Название',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
        ];
    }
}
