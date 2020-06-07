<?php
/**
 * Developer: Konstantin Vasin by PhpStorm
 * Company: Altasib
 * Time: 14:02
 */

namespace app\models\entity;


use mohorev\file\UploadBehavior;
use yii\db\ActiveRecord;

/**
 * SiteSettings model
 *
 * @property integer $id
 * @property string $name
 * @property string $code
 * @property string $type
 * @property string $value
 */
class SiteSettings extends ActiveRecord
{
    public $file;

    public static function tableName()
    {
        return "site_settings";
    }

    public function rules()
    {
        return [
            [['name', 'value', 'code', 'type'], 'required'],
            [['name', 'value', 'code'], 'string'],

//            [['file'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
        ];
    }

//    public function behaviors()
//    {
//        return [
//            [
//                'class' => UploadBehavior::class,
//                'attribute' => 'preview_image',
//                'scenarios' => ['default'],
//                'path' => '@webroot/upload/',
//                'url' => '@web/upload/',
//            ],
//        ];
//    }

    public function attributeLabels()
    {
        return [
            'name' => 'Название',
            'value' => 'Значение',
            'type' => 'Тип параметра',
            'code' => 'Символьный код',
            'file' => 'Файл',
        ];
    }

    public static function getValueByCode($code)
    {
        try {
            return self::findByCode($code)->value;
        } catch (\Exception $exception) {
            return "Свойство не создано";
        }
    }

    public static function findByCode($code)
    {
        return static::findOne(['code' => $code]);
    }
}