<?php

namespace app\modules\media\widgets\UploadWidget;


use yii\base\Widget;
use yii\helpers\Html;

//PromocodeFieldWidget
class UploadWidget extends Widget
{
    public $model;
    public $attribute;

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        parent::run();
        echo Html::fileInput('Product[image]');
        echo Html::radioList('MediaUpload', null, ['Сохранить на сервере', 'Сохранить на CDN']);
    }
}