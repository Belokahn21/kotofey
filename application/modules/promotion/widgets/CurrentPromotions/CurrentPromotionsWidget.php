<?php

namespace app\modules\promotion\widgets\CurrentPromotions;

use app\modules\promotion\models\helpers\PromotionHelper;
use yii\base\Widget;

class CurrentPromotionsWidget extends Widget
{
    public $view = 'default';
    public $models;

    public function run()
    {
        if (!$this->models) $this->models = PromotionHelper::getActualPromotions();

        if (!$this->models) return false;

        return $this->render($this->view, [
            'models' => $this->models
        ]);
    }
}