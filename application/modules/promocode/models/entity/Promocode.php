<?php

namespace app\modules\promocode\models\entity;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "promocode".
 *
 * @property int $id
 * @property string $code
 * @property int $count
 * @property int $discount
 * @property int $created_at
 * @property int $updated_at
 */
class Promocode extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'promocode';
    }
    public function behaviors()
	{
		return [
			TimestampBehavior::className(),
		];
	}

	public function rules()
    {
        return [
            [['count', 'discount', 'created_at', 'updated_at'], 'integer'],
            [['code'], 'string', 'max' => 255],
            [['code'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'Code',
            'count' => 'Count',
            'discount' => 'Discount',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
