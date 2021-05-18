<?php

namespace app\modules\promotion\widgets\CurrentPromotions;

use app\modules\promotion\models\helpers\PromotionHelper;
use yii\base\Widget;

class CurrentPromotionsWidget extends Widget
{
    public $view = 'default';

    public function run()
    {
        $models = PromotionHelper::getActualPromotions();

        if (!$models || \Yii::$app->user->id != 1) return false;

        return $this->render($this->view, [
            'models' => $models
        ]);
    }
}