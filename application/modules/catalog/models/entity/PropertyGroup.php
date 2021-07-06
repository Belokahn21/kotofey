<?php

namespace app\modules\catalog\models\entity;

use app\modules\site\models\behaviors\CacheBehavior;
use Yii;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "property_group".
 *
 * @property int $id
 * @property int|null $is_active
 * @property string|null $name
 * @property string|null $slug
 * @property int $sort
 * @property int|null $created_at
 * @property int|null $updated_at
 */
class PropertyGroup extends \yii\db\ActiveRecord
{
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            [
                'class' => SluggableBehavior::className(),
                'attribute' => 'name',
                'ensureUnique' => true,
            ],
            CacheBehavior::className()
        ];
    }

    public function rules()
    {
        return [
            [['is_active', 'sort', 'created_at', 'updated_at'], 'integer'],
            [['name', 'slug'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'is_active' => 'Активность',
            'name' => 'Название',
            'slug' => 'Символьный код',
            'sort' => 'Сортировка',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
        ];
    }
}
