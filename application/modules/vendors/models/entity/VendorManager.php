<?php

namespace app\modules\vendors\models\entity;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "vendor_manager".
 *
 * @property int $id
 * @property int|null $is_active
 * @property int|null $sort
 * @property int|null $vendor_id
 * @property string|null $name
 * @property string|null $method_buy
 * @property int|null $phone
 * @property string|null $email
 * @property int|null $created_at
 * @property int|null $updated_at
 */
class VendorManager extends \yii\db\ActiveRecord
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
            [['is_active', 'sort', 'vendor_id', 'phone', 'created_at', 'updated_at'], 'integer'],
            [['name', 'method_buy', 'email'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'is_active' => 'Is Active',
            'sort' => 'Sort',
            'vendor_id' => 'Vendor ID',
            'name' => 'Name',
            'method_buy' => 'Method Buy',
            'phone' => 'Phone',
            'email' => 'Email',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
