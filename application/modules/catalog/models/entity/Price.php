<?php

namespace app\modules\catalog\models\entity;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "price".
 *
 * @property int $id
 * @property string|null $name
 * @property int|null $is_active
 * @property int|null $is_main
 * @property int|null $sort
 * @property int|null $created_at
 * @property int|null $updated_at
 */
class Price extends \yii\db\ActiveRecord
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
            [['is_active'],'default','value' => 1],

            [['sort'],'default','value' => 500],

            [['is_active', 'is_main', 'sort', 'created_at', 'updated_at'], 'integer'],

            [['name'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'is_active' => 'Is Active',
            'is_main' => 'Is Main',
            'sort' => 'Sort',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
