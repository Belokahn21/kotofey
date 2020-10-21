<?php

namespace app\modules\media\components;

use Tinify\Tinify;
use yii\base\Component;
use yii\web\UploadedFile;

class ImageCompress extends Component
{
    public $apiKey;
    public $maxCompressCount;
    public $maxFileSize = 5000000;

    public function init()
    {
        parent::init();
    }

    public function applyImage(UploadedFile $image)
    {
        // Если по тарифу мы использовали все сжатия
        if (\Tinify\compressionCount() >= $this->maxCompressCount) {
            return false;
        }

        // Если картинка больше разрешенного размера
        if ($image->size > $this->maxFileSize) {
            return false;
        }

        Tinify::setKey($this->apiKey);

        $source = \Tinify\fromFile($image->tempName);
        return $source->toFile($image->tempName) > 0;
    }
}