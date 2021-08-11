<?php

namespace app\modules\catalog\models\entity;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "product_to_breed".
 *
 * @property int $id
 * @property int $breed_id
 * @property int $product_id
 * @property int $animal_id
 * @property int|null $created_at
 * @property int|null $updated_at
 */
class ProductToBreed extends \yii\db\ActiveRecord
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
            [['breed_id', 'product_id', 'animal_id', 'created_at', 'updated_at'], 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'breed_id' => 'ID породы',
            'product_id' => 'ID товара',
            'animal_id' => 'ID животного',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
        ];
    }
}
