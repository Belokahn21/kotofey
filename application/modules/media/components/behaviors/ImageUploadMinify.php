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
            $compress = \Yii::$app->imageCompress;
            $compress->applyImage($this->file);


            if (is_string($path) && FileHelper::createDirectory(dirname($path))) {
                $this->save($this->file, $path);

                if ($location = \Yii::$app->request->post(Media::POST_KEY_LOCATION)) {

                    if ($location == Media::LOCATION_CDN) {

                        // save in cdn
                        $responseUploadCdn = \Yii::$app->CDN->uploadImage($path);

                        if (is_array($responseUploadCdn)) {
                            $media = new Media();
                            $media->name = $this->file->name;
                            $media->json_cdn_data = Json::encode($responseUploadCdn);
                            $media->location = $location;
                            $media->type = Media::MEDIA_TYPE_IMAGE;
                            if (!$media->validate())
                                return false;
                            if (!$media->save())
                                return false;

                            $this->owner->updateAll([
                                'media_id' => $media->id,
                            ], 'id = ' . $this->owner->id);

                            // no store server
                            $this->delete('image');

                            return true;
                        }
                    } else {

                        $media = new Media();
                        $media->name = $this->file->name;
                        $media->path = $path;
                        $media->location = $location;
                        $media->type = Media::MEDIA_TYPE_IMAGE;
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