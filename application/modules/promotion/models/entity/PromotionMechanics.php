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

    const PROMOTION_SIMPLE_DISCOUNT = 'simple';
    const PROMOTION_ADD_PRODUCT = 'p2p';

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
            [['created_at', 'updated_at'], 'integer'],
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

    public function listPromotionMechanics()
    {
        return [
            self::PROMOTION_SIMPLE_DISCOUNT => 'Скидка на товар',
            self::PROMOTION_ADD_PRODUCT => '+ товар за покупку основного',
        ];
    }
}
