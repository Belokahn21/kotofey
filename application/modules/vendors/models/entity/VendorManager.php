<?php

namespace app\modules\vendors\models\entity;

use Yii;

/**
 * This is the model class for table "vendor_manager".
 *
 * @property int $id
 * @property string $fio
 * @property int $vendor_id
 * @property int $phone
 * @property string $email
 * @property string $welcome_message
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Vendor $vendor
 */
class VendorManager extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'vendor_manager';
    }

    public function rules()
    {
        return [
            [['vendor_id', 'phone', 'created_at', 'updated_at'], 'integer'],
            [['fio', 'email', 'welcome_message'], 'string', 'max' => 255],
            [['vendor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Vendor::className(), 'targetAttribute' => ['vendor_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fio' => 'Fio',
            'vendor_id' => 'Vendor ID',
            'phone' => 'Phone',
            'email' => 'Email',
            'welcome_message' => 'Welcome Message',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function getVendor()
    {
        return $this->hasOne(Vendor::className(), ['id' => 'vendor_id']);
    }
}
