<?php

namespace app\modules\order\models\entity;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "status_order".
 *
 * @property int $id
 * @property string $name
 * @property int $created_at
 * @property int $updated_at
 */
class OrderStatus extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'status_order';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className()
        ];
    }

    public function rules()
    {
        return [
            [['name', 'created_at', 'updated_at'], 'required'],
            [['created_at', 'updated_at'], 'integer'],
            [['name'], 'string', 'max' => 256],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
        ];
    }
}
