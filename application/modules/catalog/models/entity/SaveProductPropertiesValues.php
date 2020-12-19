<?php

namespace app\modules\catalog\models\entity;


use app\modules\catalog\models\entity\SaveInformers;
use app\modules\catalog\models\entity\SaveInformersValues;
use app\modules\catalog\models\entity\SaveProductProperties;
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
 * @property SaveProductProperties $property
 * @property SaveInformers $informer
 * @property string $finalValue
 */
class SaveProductPropertiesValues extends ActiveRecord
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
        return SaveProductProperties::findOne($this->property_id);
    }

    public function getInformer()
    {
        $property = $this->getProperty();
        return (($property->type == 0) ?: SaveInformers::findOne($property->informer_id));
    }

    public function getFinalValue()
    {
        $cache = \Yii::$app->cache;
        if ($this->property->type == 1) {
            $element = $cache->getOrSet(sprintf('gfvinformer:%s:%s', $this->informer->id, $this->value), function () {
                return SaveInformersValues::find()->where(['informer_id' => $this->informer->id, 'id' => $this->value])->one();
            });

            if ($element) return $element->name;

        } else {
            return $this->value;
        }

        return false;
    }

}