<?php

namespace app\modules\media\models\entity;

use app\modules\media\components\behaviors\ImageUploadMinify;
use app\modules\media\components\behaviors\MediaFileUpload;
use mohorev\file\UploadBehavior;
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
 * @property string $type cdn/server
 * @property int|null $created_at
 * @property int|null $updated_at
 */
class Media extends \yii\db\ActiveRecord
{
    const LOCATION_SERVER = 'server';
    const LOCATION_CDN = 'cdn';
    const POST_KEY_LOCATION = 'locationStore';

    const MEDIA_TYPE_IMAGE = 'image';
    const MEDIA_TYPE_VIDEO = 'video';
    const MEDIA_TYPE_MUSIC = 'music';


    public function beforeDelete()
    {
        if ($this->location == self::LOCATION_CDN) {
            if ($this->cdnData['public_id']) {
                if (!\Yii::$app->CDN->remove($this->cdnData['public_id'])) {
                    return false;
                }
            }
        }

        return parent::beforeDelete(); // TODO: Change the autogenerated stub
    }

    public function rules()
    {
        return [
            [['name', 'location'], 'required'],

            [['created_at', 'updated_at'], 'integer'],

            [['name', 'location', 'type'], 'string', 'max' => 255],

            ['path', 'file', 'extensions' => \Yii::$app->params['files']['extensions'], 'skipOnEmpty' => true]
        ];
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            [
                'class' => MediaFileUpload::class,
                'attribute' => 'path',
                'scenarios' => ['default'],
                'path' => '@webroot/upload/',
                'url' => '@web/upload/'
            ],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Имя файла',
            'path' => 'Путь до файла',
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