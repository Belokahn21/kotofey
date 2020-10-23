<?php

namespace app\modules\media\models\entity;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\Json;

/**
 * This is the model class for table "media".
 *
 * @property int $id
 * @property string $name media file name
 * @property string|null $path full path media
 * @property string|null $json_cdn_data full path media
 * @property object $cdnData
 * @property string $location cdn/server
 * @property int|null $created_at
 * @property int|null $updated_at
 */
class Media extends \yii\db\ActiveRecord
{
    const LOCATION_SERVER = 'server';
    const LOCATION_CDN = 'cdn';
    const POST_KEY_LOCATION = 'locationStore';

    public static function tableName()
    {
        return 'media';
    }

    public function rules()
    {
        return [
            [['name', 'location'], 'required'],

            [['created_at', 'updated_at'], 'integer'],

            [['name', 'path', 'location'], 'string', 'max' => 255],
        ];
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Имя файла',
            'path' => 'Путь то записи',
            'location' => 'Место хранения',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
        ];
    }

    public function getCdnData()
    {
        return Json::decode($this->json_cdn_data);
    }

    public function getLocations()
    {
        return [
            self::LOCATION_CDN => "CDN",
            self::LOCATION_SERVER => 'Локальный сервер'
        ];
    }
}