<?php

namespace app\modules\media\widgets\MediaBrowser;

use app\modules\site\models\tools\Debug;
use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Json;

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
        echo Html::tag('div', null, ['class' => 'media-browser-react', 'data-config' => Json::encode([
            'model' => 'Product',
            'attribute' => str_replace('properties', '[properties]', $this->attribute)
        ])]);
    }
}