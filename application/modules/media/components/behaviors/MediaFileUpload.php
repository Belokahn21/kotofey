<?php

namespace app\modules\media\components\behaviors;

use app\modules\media\models\entity\Media;
use mohorev\file\UploadBehavior;
use yii\base\InvalidArgumentException;
use yii\db\BaseActiveRecord;
use yii\helpers\FileHelper;
use yii\helpers\Json;
use yii\web\UploadedFile;

class MediaFileUpload extends UploadBehavior
{
    public function beforeSave()
    {
        /** @var BaseActiveRecord $model */
        $model = $this->owner;
        if (in_array($model->scenario, $this->scenarios)) {
            if ($this->file instanceof UploadedFile) {
                if (!$model->getIsNewRecord() && $model->isAttributeChanged($this->attribute)) {
                    if ($this->unlinkOnSave === true) {
                        $this->delete($this->attribute, true);
                    }
                }
                $model->setAttribute($this->attribute, $this->file->name);
            } else {
                // Protect attribute
                unset($model->{$this->attribute});
            }
        } else {
            if (!$model->getIsNewRecord() && $model->isAttributeChanged($this->attribute)) {
                if ($this->unlinkOnSave === true) {
                    $this->delete($this->attribute, true);
                }
            }
        }

        if ($this->file instanceof UploadedFile) {
            $path = $this->getUploadPath($this->attribute);

            switch ($this->owner->location) {
                case Media::LOCATION_CDN:
                    $this->saveToCDN($this->file->tempName);
                    break;
                case Media::LOCATION_SERVER:
                    $this->saveToServer($path);
                    break;
            }
        }
    }

    /**
     * This method is called at the end of inserting or updating a record.
     * @throws \yii\base\InvalidArgumentException
     */
    public function afterSave()
    {

    }

    public function afterDelete()
    {
        $this->removeMediaImage();
        // если не было media_id
        parent::afterDelete();
    }

    private function saveToServer($path)
    {
        if (is_string($path) && FileHelper::createDirectory(dirname($path))) {
            $this->save($this->file, $path);
            $this->afterUpload();
        } else {
            throw new InvalidArgumentException(
                "Directory specified in 'path' attribute doesn't exist or cannot be created."
            );
        }
    }

    private function saveToCDN($path)
    {
        $responseUploadCdn = \Yii::$app->CDN->uploadImage($path);

        if (is_array($responseUploadCdn)) {
            $this->owner->json_cdn_data = Json::encode($responseUploadCdn);
        }
    }

    private function removeMediaImage()
    {
        if ($this->owner->media_id) {
            $media = Media::findOne($this->owner->media_id);

            if ($media) {
                if ($media->location == Media::LOCATION_CDN) {
                    if (!\Yii::$app->CDN->remove($media->cdnData['public_id'])) {
                        return false;
                    }
                }

                $media->delete();
                return true;
            }
        }
    }
}