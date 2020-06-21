<?php

namespace app\modules\catalog\models\form;


use yii\base\Model;
use yii\web\UploadedFile;

class SibagroUpload extends Model
{
    public $file;

    public function rules()
    {
        return [
            ['file', 'file', 'extensions' => 'html']
        ];
    }

    public function parse()
    {
        $file = UploadedFile::getInstance($this, 'file');

        print_r($file);
    }
}