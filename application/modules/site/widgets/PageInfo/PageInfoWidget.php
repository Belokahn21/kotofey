<?php


namespace app\modules\site\widgets\PageInfo;


use yii\base\Widget;

class PageInfoWidget extends Widget
{
    public $view = 'default';

    public function run()
    {
        if (\Yii::$app->user->id != 1) return false;

        /* made by ReactJS */
        return $this->render($this->view);
    }
}