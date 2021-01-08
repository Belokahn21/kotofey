<?php

namespace app\modules\promotion\models\entity;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "promotion_mechanics".
 *
 * @property int $id
 * @property string $name
 * @property string $type
 * @property int $created_at
 * @property int $updated_at
 */
class PromotionMechanics extends \yii\db\ActiveRecord
{
    public function behaviors()
    {
        return [
            TimestampBehavior::className()
        ];
    }

    public static function tableName()
    {
        return 'promotion_mechanics';
    }

    public function rules()
    {
        return [
            [['name', 'type'], 'required'],
            [['name', 'type'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'type' => 'Type',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
