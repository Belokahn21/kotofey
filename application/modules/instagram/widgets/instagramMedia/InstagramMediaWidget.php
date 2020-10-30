<?php

namespace app\modules\instagram\widgets\instagramMedia;


use app\modules\site\models\tools\Debug;
use app\modules\instagram\models\tools\Instagram;
use yii\base\Widget;

class InstagramMediaWidget extends Widget
{
    public $view = 'default';
    public $cacheTime = 36000;

    public function run()
    {
        $media = Instagram::getData();

        return $this->render($this->view, [
            'media' => $media,
            'cacheTime' => $this->cacheTime
        ]);
    }
}