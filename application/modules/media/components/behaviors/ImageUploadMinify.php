<?php

namespace app\modules\media\components\behaviors;


use app\models\tool\Debug;
use app\modules\catalog\models\entity\Product;
use app\modules\media\models\entity\Media;
use mohorev\file\UploadBehavior;
use yii\base\InvalidArgumentException;
use yii\helpers\FileHelper;
use yii\helpers\Json;
use yii\web\UploadedFile;

class ImageUploadMinify extends UploadBehavior
{
    public function afterSave()
    {
        if ($this->file instanceof UploadedFile) {

            $path = $this->getUploadPath($this->attribute);

            // re-save image by path ?
//            $compress = \Yii::$app->imageCompress;
//            $compress->applyImage($this->file);


            if (is_string($path) && FileHelper::createDirectory(dirname($path))) {
                $this->save($this->file, $path);


                if ($location = \Yii::$app->request->post(Media::POST_KEY_LOCATION)) {

                    if ($location == Media::LOCATION_CDN) {
                        // save in cdn

//                        \Cloudinary::config(array(
//                            "cloud_name" => "kotofey-store",
//                            "api_key" => "313768283447262",
//                            "api_secret" => "Wm28QI4nQIolSV1J7Hd0hArxuzM",
//                            "secure" => true
//                        ));

                        $responseUploadCdn = \Yii::$app->CDN->uploadImage($path);


                        if (is_array($responseUploadCdn)) {
                            if (array_key_exists('public_id', $responseUploadCdn)) {
                                $media = new Media();
                                $media->name = $this->file->name;
                                $media->json_cdn_data = Json::encode($responseUploadCdn);
                                $media->path = $responseUploadCdn['secure_url'];
                                $media->location = $location;
                                if (!$media->validate())
                                    return false;
                                if (!$media->save())
                                    return false;

                                $this->owner->updateAll([
                                    'media_id' => $media->id,
                                ], 'id = ' . $this->owner->id);

                                return true;
                            }
                        }
                    } else {
                        $media = new Media();
                        $media->name = $this->file->name;
                        $media->path = $path;
                        $media->location = $location;
                        if (!$media->validate())
                            return false;
                        if (!$media->save())
                            return false;

                        $this->owner->updateAll([
                            'media_id' => $media->id
                        ], 'id = ' . $this->owner->id);

                        $this->afterUpload();
                    }
                }
            } else {
                throw new InvalidArgumentException(
                    "Directory specified in 'path' attribute doesn't exist or cannot be created."
                );
            }
        }
    }
}