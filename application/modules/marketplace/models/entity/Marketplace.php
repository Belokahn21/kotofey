<?php

namespace app\modules\marketplace\models\entity;

use Yii;

/**
 * This is the model class for table "marketplace".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $slug
 * @property int|null $is_active
 * @property int|null $sort
 * @property int|null $created_at
 * @property int|null $updated_at
 */
class Marketplace extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'marketplace';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['is_active', 'sort', 'created_at', 'updated_at'], 'integer'],
            [['name', 'slug'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'slug' => 'Slug',
            'is_active' => 'Is Active',
            'sort' => 'Sort',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
