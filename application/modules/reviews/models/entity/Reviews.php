<?php

namespace app\modules\reviews\models\entity;

use Yii;

/**
 * This is the model class for table "reviews".
 *
 * @property int $id
 * @property int|null $user_id
 * @property int $product_id
 * @property string $text
 * @property string|null $image
 * @property int|null $rate
 * @property int|null $created_at
 * @property int|null $updated_at
 */
class Reviews extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'reviews';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'product_id', 'rate', 'created_at', 'updated_at'], 'integer'],
            [['product_id', 'text'], 'required'],
            [['text'], 'string'],
            [['image'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'product_id' => 'Product ID',
            'text' => 'Text',
            'image' => 'Image',
            'rate' => 'Rate',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
