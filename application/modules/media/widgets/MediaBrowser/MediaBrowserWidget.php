<?php

namespace app\modules\media\widgets\MediaBrowser;

use yii\base\Widget;
use yii\helpers\Html;

class MediaBrowserWidget extends Widget
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

        //render by reactjs
        echo Html::tag('div', null, ['class' => 'media-browser-react']);
    }
}