<?php

namespace app\modules\catalog\models\entity;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "composition_products".
 *
 * @property int $id
 * @property int $product_id
 * @property int $composition_id
 * @property int $metric_id
 * @property string $value
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property Composition $composition
 * @property Product $product
 */
class CompositionProducts extends \yii\db\ActiveRecord
{
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    public function rules()
    {
        return [
            [['product_id', 'composition_id', 'created_at', 'updated_at'], 'integer'],

            [['metric_id', 'value'], 'string'],
        ];
    }

    public function getComposition()
    {
        return $this->hasOne(Composition::className(), ['id' => 'composition_id']);
    }

    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'ID товара',
            'composition_id' => 'ID элемента состава',
            'metric_id' => 'Измерение',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
        ];
    }
}
