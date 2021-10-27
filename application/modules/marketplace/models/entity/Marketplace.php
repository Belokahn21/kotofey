<?php

namespace app\modules\marketplace\models\entity;

use Yii;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;

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
    public function rules()
    {
        return [
            [['is_active'], 'boolean'],
            [['is_active'], 'default', 'value' => true],


            [['is_active', 'sort', 'created_at', 'updated_at'], 'integer'],
            [['sort'], 'default', 'value' => 500],

            [['name', 'slug'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'slug' => 'Символьный код',
            'is_active' => 'Активность',
            'sort' => 'Сортировка',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
        ];
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            [
                'class' => SluggableBehavior::className(),
                'attribute' => 'name',
                'ensureUnique' => true,
                'immutable' => true
            ],
        ];
    }
}
