<?php

namespace app\modules\pets\models\entity;

use app\modules\pets\models\helpers\AnimalHelper;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "animal".
 *
 * @property int $id
 * @property string|null $name
 * @property int|null $sort
 * @property int|null $is_active
 * @property string|null $icon
 * @property int|null $created_at
 * @property int|null $updated_at
 */
class Animal extends \yii\db\ActiveRecord
{
    public function behaviors()
    {
        return [
            TimestampBehavior::className()
        ];
    }

    public function rules()
    {
        return [
            [['sort'], 'default', 'value' => 500],
            [['is_active'], 'default', 'value' => 1],
            [['sort', 'is_active', 'created_at', 'updated_at'], 'integer'],
            [['name', 'icon'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'sort' => 'Sort',
            'is_active' => 'Is Active',
            'icon' => 'Icon',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function extraFields()
    {
        return [
            'image' => function ($model) {
                return AnimalHelper::getImageUrl($model);
            },
        ];
    }
}
