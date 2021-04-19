<?php

namespace app\modules\cdn\widgets\CdnInput;


use app\modules\media\models\entity\Media;
use yii\base\Widget;
use yii\helpers\Html;

class CdnInputWidget extends Widget
{
    public $model;
    public $attribute;
    public $dopAttr;

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

        if ($this->dopAttr) {
            echo Html::tag('hr');
            echo Html::activeHiddenInput($this->model, $this->dopAttr);
            echo Html::tag('div', false, ['class' => 'cdn-modal-react']);
        }
    }
}