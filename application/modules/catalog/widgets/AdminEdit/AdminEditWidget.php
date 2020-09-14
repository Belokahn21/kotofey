<?php

namespace app\modules\catalog\widgets\AdminEdit;


use app\models\tool\Debug;
use yii\bootstrap\Widget;

class AdminEditWidget extends Widget
{
    public $view = 'default';

    public function run()
    {
        if (!$this->isProductAction()) {
            return false;
        }


        return $this->render($this->view);
    }

    public function isProductAction()
    {
        return \Yii::$app->controller->getRoute() === "catalog/product/view";
    }
}