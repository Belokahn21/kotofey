<?php

namespace app\modules\media\widgets\MediaBrowser;

use app\modules\site\models\tools\Debug;
use yii\helpers\StringHelper;
use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Json;

class MediaBrowserWidget extends Widget
{
    public $model;
    public $attribute;
    public $values;
    public $is_multiple = false;

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        parent::run();

        //render by reactjs
        echo Html::tag('div', null, ['class' => 'media-browser-react', 'data-config' => Json::encode([
            'model' => StringHelper::basename(get_class($this->model)),
            'attribute' => preg_replace('/(\b[^\d\W]+\b)/', '[$1]', $this->attribute),
            'values' => $this->values
        ])]);
    }
}