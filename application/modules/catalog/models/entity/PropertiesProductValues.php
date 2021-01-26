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
 * @property PropertiesVariants $variant
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

    function getVariant()
    {
        return $this->hasOne(PropertiesVariants::className(), ['property_id' => 'property_id', 'id' => 'value']);
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'property_id' => 'ID свойства',
            'product_id' => 'ID товара',
            'value' => 'Значение',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
        ];
    }
}
