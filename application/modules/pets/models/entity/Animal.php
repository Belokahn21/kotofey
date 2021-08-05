<?php

namespace app\modules\pets\models\entity;

use app\modules\media\models\entity\Media;
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
 * @property int|null $media_id
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property Media $media
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

            [['sort', 'is_active', 'created_at', 'updated_at', 'media_id'], 'integer'],

            [['name', 'icon'], 'string', 'max' => 255],

        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'sort' => 'Сортировка',
            'is_active' => 'Активность',
            'icon' => 'Иконка',
            'media_id' => 'Картинка',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
        ];
    }

    public function getMedia()
    {
        return $this->hasOne(Media::className(), ['id' => 'media_id']);
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
