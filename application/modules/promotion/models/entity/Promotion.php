<?php

namespace app\modules\promotion\models\entity;

use app\modules\content\models\behaviors\DateToIntBehaviors;
use app\modules\media\components\behaviors\ImageUploadMinify;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "promotion".
 *
 * @property int $id
 * @property string $name
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
    const SCENARIO_DEFAULT = 'default';

    public function scenarios()
    {
        return [
            self::SCENARIO_DEFAULT => ['name', 'is_active', 'start_at', 'end_at', 'image', 'created_at', 'updated_at']
        ];
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            DateToIntBehaviors::className(),
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
            [['name'], 'required'],
            [['is_active', 'created_at', 'updated_at', 'media_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['start_at', 'end_at'], 'safe'],
            [['image'], 'file', 'skipOnEmpty' => true, 'extensions' => \Yii::$app->params['files']['extensions']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
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
}
