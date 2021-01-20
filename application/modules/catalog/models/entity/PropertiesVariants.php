<?php

namespace app\modules\catalog\models\entity;

use app\modules\media\components\behaviors\ImageUploadMinify;
use Yii;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "properties_variants".
 *
 * @property int $id
 * @property int $property_id
 * @property int $is_active
 * @property int|null $media_id
 * @property string|null $image
 * @property string|null $view
 * @property string|null $link
 * @property string $name
 * @property string|null $slug
 * @property string|null $text
 * @property int $sort
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property Properties $property
 */
class PropertiesVariants extends \yii\db\ActiveRecord
{
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
            [
                'class' => ImageUploadMinify::class,
                'attribute' => 'image',
                'scenarios' => ['default'],
                'path' => '@webroot/upload/',
                'url' => '@web/upload/'
            ],
        ];
    }

    public function rules()
    {
        return [
            [['property_id', 'name'], 'required'],
            [['property_id', 'is_active', 'media_id', 'sort'], 'integer'],
            [['link', 'text'], 'string'],
            [['image', 'view', 'slug'], 'string', 'max' => 255],
            [['name'], 'string', 'max' => 128],
            [['property_id'], 'exist', 'skipOnError' => true, 'targetClass' => Properties::className(), 'targetAttribute' => ['property_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'property_id' => 'ID свойства',
            'is_active' => 'Активность',
            'media_id' => 'Картинка',
            'image' => 'Картинка',
            'view' => 'Шаблон',
            'link' => 'Ссылка',
            'name' => 'Значение',
            'slug' => 'Символьный код',
            'text' => 'Контент',
            'sort' => 'Сортировка',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
        ];
    }

    /**
     * Gets query for [[Property]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProperty()
    {
        return $this->hasOne(Properties::className(), ['id' => 'property_id']);
    }
}
