<?php

namespace app\modules\order\models\entity;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "customer".
 *
 * @property int|null $phone
 * @property int|null $is_active
 * @property int|null $sort
 * @property string|null $name
 * @property int|null $created_at
 * @property int|null $updated_at
 */
class Customer extends \yii\db\ActiveRecord
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
            [['phone'], 'required'],

            [['sort'], 'default', 'value' => 500],

            [['phone', 'is_active', 'sort', 'created_at', 'updated_at'], 'integer'],

            [['name'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'phone' => 'Phone',
            'is_active' => 'Is Active',
            'sort' => 'Sort',
            'name' => 'Name',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function extraFields()
    {
        return [
            'cross' => function ($model) {
                return time();
            }
        ];
    }
}
