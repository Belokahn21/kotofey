<?php

namespace app\modules\marketplace\widgets\MarketplaceReport;

use yii\base\Widget;

class MarketplaceReportWidget extends Widget
{
    public $view = 'default';

    public function run()
    {
        return $this->render($this->view);
    }
}