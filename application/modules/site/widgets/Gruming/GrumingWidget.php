<?php

namespace app\modules\site\widgets\Gruming;


use app\modules\site\models\forms\GrumingForm;
use yii\bootstrap\Widget;

class GrumingWidget extends Widget
{
    public $view = 'default';

    public function run()
    {
        $model = new GrumingForm();

        return $this->render($this->view, [
            'model' => $model
        ]);
    }
}