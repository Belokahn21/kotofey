<?php

namespace app\modules\site\widgets\SocialMe;


use app\modules\site_settings\models\entity\SiteSettings;
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
            [
                'image' => '/images/whatsapp.png',
                'url' => 'whatsapp://send?phone=+79967026637',
//                'url' => 'whatsapp://send?phone=' . SiteSettings::getValueByCode('phone_1'),
            ],
        ];
        return $this->render($this->view, [
            'items' => $items
        ]);
    }
}