<?php

namespace app\modules\media\components\behaviors;


use mohorev\file\UploadBehavior;
use yii\base\InvalidArgumentException;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

class ImageUploadMinify extends UploadBehavior
{
    public function afterSave()
    {
        if ($this->file instanceof UploadedFile) {

            $path = $this->getUploadPath($this->attribute);

            // re-save image by path ?
            $compress =\Yii::$app->imageCompress;
            $compress->applyImage($this->file);

            if (is_string($path) && FileHelper::createDirectory(dirname($path))) {
                $this->save($this->file, $path);
                $this->afterUpload();
            } else {
                throw new InvalidArgumentException(
                    "Directory specified in 'path' attribute doesn't exist or cannot be created."
                );
            }
        }
    }
}