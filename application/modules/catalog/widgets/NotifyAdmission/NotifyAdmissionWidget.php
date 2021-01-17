<?php


namespace app\modules\catalog\widgets\NotifyAdmission;


use yii\base\Widget;

class NotifyAdmissionWidget extends Widget
{
    public $view = 'default';
    public $product;

    public function run()
    {
        return $this->render($this->view, [
            'product' => $this->product
        ]);
    }
}