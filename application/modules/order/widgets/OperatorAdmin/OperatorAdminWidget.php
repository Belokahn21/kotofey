<?php


namespace app\modules\order\widgets\OperatorAdmin;


use yii\base\Widget;

class OperatorAdminWidget extends Widget
{
    public $view = 'default';

    public function run()
    {
        if (\Yii::$app->user->id != 1) return false;
        return $this->render($this->view);
    }
}