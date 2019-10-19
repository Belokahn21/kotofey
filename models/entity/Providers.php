<?php

namespace app\models\entity;


use mohorev\file\UploadBehavior;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

class Providers extends ActiveRecord
{
    const SCENARIO_INSERT = 'insert';
    const SCENARIO_UPDATE = 'update';

    public function rules()
    {
        return [
            [['name'], 'required'],

            [['name', 'notes', 'description'], 'string'],

            [['sort'], 'default', 'value' => 500],

            [['image'], 'file', 'extensions' => 'png, jpg, jpeg'],
        ];
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            [
                'class' => UploadBehavior::class,
                'attribute' => 'image',
                'scenarios' => ['insert', 'update'],
                'path' => '@webroot/upload/',
                'url' => '@web/upload/',
            ],
            [
                'class' => SluggableBehavior::class,
                'attribute' => 'name',
                'ensureUnique' => true,
            ],
        ];
    }

    public function scenarios()
    {
        return [
            self::SCENARIO_INSERT => ['name', 'description', 'notes', 'active', 'sort', 'image', 'link'],
            self::SCENARIO_UPDATE => ['name', 'description', 'notes', 'active', 'sort', 'image', 'link'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Назание',
            'slug' => 'Символьный код',
            'description' => 'Описание',
            'notes' => 'Заметки',
            'link' => 'Ссылка',
            'active' => 'Активность',
            'image' => 'Картинка',
            'sort' => 'Сортировка',
        ];
    }
}