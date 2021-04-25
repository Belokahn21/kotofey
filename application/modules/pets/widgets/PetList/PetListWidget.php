<?php


namespace app\modules\pets\widgets\PetList;


use app\modules\pets\models\entity\Pets;
use yii\base\Widget;

class PetListWidget extends Widget
{
    public $view = 'default';

    public function run()
    {
        $models = Pets::find()->where(['user_id' => \Yii::$app->user->identity->id, 'status_id' => Pets::STATUS_ON])->all();

        return $this->render($this->view, [
            'models' => $models
        ]);
    }
}