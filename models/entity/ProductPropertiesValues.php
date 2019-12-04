<?php
namespace app\models\entity;


use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * ProductPropertiesValues model
 *
 * @property integer $id
 * @property string $property_id
 * @property string $product_id
 * @property string $value
 * @property ProductProperties $property
 * @property Informers $informer
 * @property string $finalValue
 */
class ProductPropertiesValues extends ActiveRecord
{
    public static function tableName()
    {
        return "product_properties_values";
    }

    public function rules()
    {
        return [
            [['product_id', 'property_id'], 'required', 'message' => 'Поле {attribute} должно быть заполнено'],

            ['value', 'string'],
        ];
    }

    public function getProperty()
    {
        return ProductProperties::findOne($this->property_id);
    }

    public function getInformer()
    {
        $property = $this->getProperty();
        return (($property->type == 0) ?: Informers::findOne($property->informer_id));
    }

    public function getFinalValue()
    {
        if ($this->property->type == 1) {
            return InformersValues::find()->where(['informer_id' => $this->informer->id, 'id' => $this->value])->one()->name;
        } else {
            return $this->value;
        }
    }

}