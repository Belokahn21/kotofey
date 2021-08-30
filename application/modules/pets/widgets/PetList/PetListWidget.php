<?php

namespace app\modules\pets\widgets\PetList;

use app\modules\pets\models\entity\Pets;
use yii\base\Widget;

class PetListWidget extends Widget
{
    public $view = 'default';

    public function run()
    {
        $user_id = \Yii::$app->user->identity->id;

        $models = \Yii::$app->cache->getOrSet('pet_list_' . $user_id, function () use ($user_id) {
            return Pets::find()->where(['user_id' => $user_id, 'status_id' => Pets::STATUS_ON])->all();
        });

        return $this->render($this->view, [
            'models' => $models
        ]);
    }
}