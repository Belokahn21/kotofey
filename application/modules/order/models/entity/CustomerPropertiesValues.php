<?php

namespace app\modules\order\models\entity;

use Yii;

/**
 * This is the model class for table "customer_properties_values".
 *
 * @property int $id
 * @property int $customer_id
 * @property int $property_id
 * @property string|null $value
 * @property int|null $created_at
 * @property int|null $updated_at
 */
class CustomerPropertiesValues extends \yii\db\ActiveRecord
{
    public function rules()
    {
        return [
            [['customer_id', 'property_id'], 'required'],
            [['customer_id', 'property_id', 'created_at', 'updated_at'], 'integer'],
            [['value'], 'string', 'max' => 255],
        ];
    }
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'customer_id' => 'Customer ID',
            'property_id' => 'Property ID',
            'value' => 'Значение',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
        ];
    }
}
