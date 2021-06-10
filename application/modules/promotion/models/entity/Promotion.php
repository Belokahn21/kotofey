<?php

namespace app\modules\promotion\models\entity;

use app\modules\catalog\models\entity\Product;
use app\modules\content\models\behaviors\DateToIntBehaviors;
use app\modules\media\components\behaviors\ImageUploadMinify;
use app\modules\media\models\entity\Media;
use Yii;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "promotion".
 *
 * @property int $id
 * @property int $sort
 * @property string $name
 * @property string $slug
 * @property int|null $is_active
 * @property int|null $media_id
 * @property int|null $start_at
 * @property int|null $end_at
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property PromotionProductMechanics[] $promotionProductMechanics
 */
class Promotion extends \yii\db\ActiveRecord
{
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            DateToIntBehaviors::className(),
            [
                'class' => SluggableBehavior::className(),
                'attribute' => 'name',
                'ensureUnique' => true,
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
            [['is_active'], 'default', 'value' => 1],
            [['sort'], 'default', 'value' => 500],
            [['name'], 'required'],
            [['is_active', 'created_at', 'updated_at', 'sort', 'media_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['start_at', 'end_at'], 'safe'],
            [['image'], 'file', 'skipOnEmpty' => true, 'extensions' => \Yii::$app->params['files']['extensions']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sort' => 'Сортировка',
            'name' => 'Название',
            'is_active' => 'Активность',
            'media_id' => 'Изображение',
            'image' => 'Изображение',
            'start_at' => 'Начало',
            'end_at' => 'Конец',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
        ];
    }

    public function getPromotionProductMechanics()
    {
        return $this->hasMany(PromotionProductMechanics::className(), ['promotion_id' => 'id']);
    }

    public function getMedia()
    {
        return $this->hasOne(Media::className(), ['id' => 'media_id']);
    }

    public static function findOneBySlug($slug)
    {
        return static::findOne(['slug' => $slug]);
    }
}
