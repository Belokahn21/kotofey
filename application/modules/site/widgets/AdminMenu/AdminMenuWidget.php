<?php

namespace app\modules\site\widgets\AdminMenu;

use yii\base\Widget;

class AdminMenuWidget extends Widget
{
    public $title;
    public $links;

    public function run()
    {
        return $this->render('default', [
            'links' => $this->links,
            'title' => $this->title,
        ]);
    }
}