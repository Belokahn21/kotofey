<?php


namespace app\modules\catalog\widgets\UserAdmission;


use app\modules\catalog\models\entity\NotifyAdmission;
use yii\base\Widget;

class UserAdmissionWidget extends Widget
{
    public $view = 'default';

    public function run()
    {
        $models = NotifyAdmission::find()->where(['email' => \Yii::$app->user->identity->email])->all();
        return $this->render($this->view, [
            'models' => $models
        ]);
    }
}