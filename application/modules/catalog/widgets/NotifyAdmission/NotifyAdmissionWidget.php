<?php


namespace app\modules\catalog\widgets\NotifyAdmission;


use app\modules\catalog\models\entity\NotifyAdmission;
use yii\base\Widget;

class NotifyAdmissionWidget extends Widget
{
    public $view = 'default';
    public $product;

    public function run()
    {
        $model = new NotifyAdmission();
        return $this->render($this->view, [
            'product' => $this->product,
            'model' => $model,
        ]);
    }
}