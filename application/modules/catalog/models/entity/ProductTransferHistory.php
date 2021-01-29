<?php

namespace app\modules\catalog\models\entity;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "product_transfer_history".
 *
 * @property int $id
 * @property int $product_id
 * @property int $count
 * @property int|null $order_id
 * @property string $reason
 * @property int|null $created_at
 * @property int|null $updated_at
 */
class ProductTransferHistory extends \yii\db\ActiveRecord
{
    public function behaviors()
    {
        return [
            TimestampBehavior::className()
        ];
    }
}
