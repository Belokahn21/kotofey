<?php

namespace app\modules\delivery\models\entity;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "delivery_service".
 *
 * @property int $id
 * @property int|null $is_active
 * @property int|null $sort
 * @property string|null $name
 * @property string|null $code
 * @property string|null $description
 * @property int|null $media_id
 * @property int|null $created_at
 * @property int|null $updated_at
 */
class DeliveryService extends \yii\db\ActiveRecord
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
            [['is_active', 'sort', 'media_id', 'created_at', 'updated_at'], 'integer'],
            [['name', 'code', 'description'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'is_active' => 'Is Active',
            'sort' => 'Sort',
            'name' => 'Name',
            'code' => 'Code',
            'description' => 'Description',
            'media_id' => 'Media ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
