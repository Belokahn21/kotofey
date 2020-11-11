<?php

namespace app\modules\site\widgets\SocialMe;


use yii\bootstrap\Widget;

class SocialMe extends Widget
{
    public $view = 'default';

    public function run()
    {
        $items = [
            [
                'image' => '/images/instagram.png',
                'url' => 'https://www.instagram.com/kotofey_store/',
            ],
            [
                'image' => '/images/vk.png',
                'url' => 'https://vk.com/kotofey.store',
            ],
            [
                'image' => '/images/twitter.png',
                'url' => 'https://twitter.com/ALwcOSwoyYMJ12c',
            ],
        ];
        return $this->render($this->view, [
            'items' => $items
        ]);
    }
}