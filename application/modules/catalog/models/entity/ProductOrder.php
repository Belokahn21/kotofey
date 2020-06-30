<?php

namespace app\modules\catalog\models\entity;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "product_order".
 *
 * @property int $id
 * @property int $product_id
 * @property int $start
 * @property int $end
 * @property int $created_at
 * @property int $updated_at
 */
class ProductOrder extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product_order';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [
                ['product_id'],
                'required',
                'when' => function ($model) {
                    return !empty($model->start) && !empty($model->end);
                }
            ],
            [
                ['start', 'end'],
                'required',
                'whenClient' => 'function(){
                return $("#product-is_product_order:checkbox:checked").length==1;
            }'
            ],
            [['product_id', 'start', 'end', 'created_at', 'updated_at'], 'integer'],
        ];
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className()
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Товар',
            'start' => 'Ожадание в днях (мин)',
            'end' => 'Ожидание в днях (макс)',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
        ];
    }

    public static function findOneByProductId($product_id)
    {
        return static::findOne(['product_id' => $product_id]);
    }

    public static function productIsOrder($product_id)
    {
        return static::findOneByProductId($product_id);
    }

    public static function availableDays()
    {
        $days = array();

        for ($i = 1; $i <= 31; $i++) {
            $days[$i] = $i;
        }

        return $days;
    }
}
