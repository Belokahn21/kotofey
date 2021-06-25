<?php

namespace app\modules\catalog\models\entity;

use Yii;

/**
 * This is the model class for table "composition_products".
 *
 * @property int $id
 * @property int $product_id
 * @property int $composition_id
 * @property int $composition_type_id
 * @property int|null $created_at
 * @property int|null $updated_at
 */
class CompositionProducts extends \yii\db\ActiveRecord
{
    public function rules()
    {
        return [
            [['composition_id', 'composition_type_id'], 'required'],
            [['product_id', 'composition_id', 'composition_type_id', 'created_at', 'updated_at'], 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Product ID',
            'composition_id' => 'Composition ID',
            'composition_type_id' => 'Composition Type ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
