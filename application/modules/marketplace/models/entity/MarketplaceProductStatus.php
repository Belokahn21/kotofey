<?php

namespace app\modules\marketplace\models\entity;

use Yii;
use app\modules\catalog\models\entity\Product;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "marketplace_product_status".
 *
 * @property int $id
 * @property int $product_id
 * @property int $task_id
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property Product $product
 */
class MarketplaceProductStatus extends \yii\db\ActiveRecord
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
            [['product_id', 'task_id'], 'required'],

            [['product_id', 'task_id', 'created_at', 'updated_at'], 'integer'],

            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['product_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Товар ID',
            'task_id' => 'Task ID',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
        ];
    }

    /**
     * Gets query for [[Product]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }
}
