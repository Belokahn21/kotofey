<?php

namespace app\modules\order\widgets\FastManagerMessage;


use yii\base\Widget;

class FastManagerMessage extends Widget
{
    public $items;
    public $view = 'default';

    public function run()
    {
        if (!$this->items) {
            return false;
        }

        $vendros = array();
        foreach ($this->items as $item):
            if ($item->product->vendor_id):
                $vendros[$item->product->vendor_id][] = $item;
            endif;
        endforeach;

        return $this->render($this->view, [
            'vendros' => $vendros
        ]);
    }
}