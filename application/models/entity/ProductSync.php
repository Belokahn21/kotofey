<?php

namespace app\models\entity;

use Yii;

/**
 * This is the model class for table "product_sync".
 *
 * @property int $id
 * @property int $product_id
 * @property int $last_run_at
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Product $product
 */
class ProductSync extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product_sync';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id'], 'required'],
            [['product_id', 'last_run_at', 'created_at', 'updated_at'], 'integer'],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['product_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Product ID',
            'last_run_at' => 'Last Run At',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }
}
