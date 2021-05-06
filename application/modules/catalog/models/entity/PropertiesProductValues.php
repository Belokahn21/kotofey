<?php

namespace app\modules\catalog\models\entity;

use app\modules\media\models\entity\Media;
use Yii;
use yii\behaviors\TimestampBehavior;

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
    public function behaviors()
    {
        return [
            TimestampBehavior::className()
        ];
    }

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

    public function getMedia()
    {
        return $this->hasOne(Media::className(), ['id' => 'value']);
    }

    function getName()
    {
        if ($this->property->type == TypeProductProperties::TYPE_INFORMER) return PropertiesVariants::findOne(['property_id' => $this->property_id, 'id' => $this->value])->name;

        if ($this->property->type == TypeProductProperties::TYPE_TEXT) return $this->value;
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

    public function extraFields()
    {
        return ['media'];
    }
}
