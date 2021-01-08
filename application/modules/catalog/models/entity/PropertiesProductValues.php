<?php

namespace app\modules\catalog\models\entity;

use Yii;

/**
 * This is the model class for table "properties_product_values".
 *
 * @property int $id
 * @property int $property_id
 * @property int $product_id
 * @property string $value
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property Properties $property
 */
class PropertiesProductValues extends \yii\db\ActiveRecord
{
    public function rules()
    {
        return [
            [['property_id', 'product_id', 'value'], 'required'],
            [['property_id', 'product_id', 'created_at', 'updated_at'], 'integer'],
            [['value'], 'string', 'max' => 255],
        ];
    }

    public function getProperty()
    {
        return $this->hasOne(Properties::className(), ['id' => 'property_id']);
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'property_id' => 'Property ID',
            'product_id' => 'Product ID',
            'value' => 'Value',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
