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
        if (\Yii::$app->user->isGuest) return $this->render('nologin');

        $model = new NotifyAdmission();
        return $this->render($this->view, [
            'product' => $this->product,
            'model' => $model,
        ]);
    }
}