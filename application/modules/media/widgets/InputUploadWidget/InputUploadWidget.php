<?php


namespace app\modules\media\widgets\InputUploadWidget;


use app\modules\media\models\entity\Media;
use yii\base\Widget;
use yii\helpers\Html;

class InputUploadWidget extends Widget
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


        $media = new Media();
        echo Html::radioList(Media::POST_KEY_LOCATION, null, $media->getLocations());
        echo Html::activeFileInput($this->model, $this->attribute);
    }
}