<?php

namespace app\models\entity;

use Yii;
use yii\behaviors\TimestampBehavior;

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

    public function behaviors()
    {
        return [
            TimestampBehavior::className()
        ];
    }

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

    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

    public function push($product_id)
    {
        $this->product_id = $product_id;
        $this->last_run_at = time();

        if (!$this->validate()) {
            return false;
        }

        return $this->save();
    }

    public function reUpdate()
    {
        $this->last_run_at = time();

        if (!$this->validate()) {
            return false;
        }

        return $this->update();
    }
}
