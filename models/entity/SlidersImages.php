<?php

namespace app\models\entity;


use mohorev\file\UploadBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * SlidersImages model
 *
 * @property integer $id
 * @property integer $slider_id
 * @property integer $sort
 * @property boolean $active
 * @property string $image
 * @property string $text
 * @property string $description
 * @property string $link
 * @property integer $created_at
 * @property integer $updated_at
 */
class SlidersImages extends ActiveRecord
{
    const SCENARIO_INSERT = 'insert';
    const SCENARIO_UPDATE = 'update';

    public static function tableName()
    {
        return "sliders_images";
    }

    public function scenarios()
    {
        return [
            self::SCENARIO_INSERT => ['image', 'sort', 'active', 'text', 'description', 'slider_id', 'link'],
            self::SCENARIO_UPDATE => ['image', 'sort', 'active', 'text', 'description', 'slider_id', 'link'],
        ];
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            [
                'class' => UploadBehavior::class,
                'attribute' => 'image',
                'scenarios' => ['insert', 'update'],
                'path' => '@webroot/upload/',
                'url' => '@web/upload/',
            ],
        ];
    }

    public function rules()
    {
        return [
            [['sort'], 'default', 'value' => 500],

            [['active'], 'default', 'value' => 1],

            [['slider_id', 'sort', 'active'], 'integer'],

            [['link'], 'string'],

            [['image'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'text' => 'Название',
            'description' => 'Описание',
            'slider_id' => 'Слайдер',
            'image' => 'Картинка',
            'active' => 'Активность',
            'sort' => 'Сортировка',
            'link' => 'Ссылка',
        ];
    }
}