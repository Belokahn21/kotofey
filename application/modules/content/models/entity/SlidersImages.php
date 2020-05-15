<?php

namespace app\modules\content\models\entity;


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
 * @property integer $start_at
 * @property integer $end_at
 * @property integer $created_at
 * @property integer $updated_at
 */
class SlidersImages extends ActiveRecord
{
    public static function tableName()
    {
        return "sliders_images";
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            [
                'class' => UploadBehavior::class,
                'attribute' => 'image',
                'scenarios' => ['default'],
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

            [['slider_id'], 'required'],
            [['slider_id', 'sort', 'active'], 'integer'],

            [['link', 'text', 'description'], 'string'],

            [['end_at', 'start_at'], 'safe'],

            [['image'], 'file', 'skipOnEmpty' => true, 'extensions' => \Yii::$app->params['files']['extensions']],
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
            'start_at' => 'Начало показа',
            'end_at' => 'Конец показа',
        ];
    }


    public function afterFind()
    {
        if ($this->start_at) {
            $this->start_at = date('d.m.Y', $this->start_at);
        }

        if ($this->end_at) {
            $this->end_at = date('d.m.Y', $this->end_at);
        }
        parent::afterFind();
    }


    /**
     * @return bool
     */
    public function beforeValidate()
    {
        if ($this->start_at) {
            $this->start_at = strtotime($this->start_at);
        }

        if ($this->end_at) {
            $this->end_at = strtotime($this->end_at);
        }
        return parent::beforeValidate();
    }
}