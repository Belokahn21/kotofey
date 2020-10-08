<?php

namespace app\modules\catalog\widgets\Sort;


use yii\base\Widget;

class ProductSortWidget extends Widget
{
    public $view = 'default';

    public function run()
    {
        $sort = [
            [
                'name' => 'Сначала дешевые',
                'key' => 'sort',
                'value' => 'asc',
            ],
            [
                'name' => 'Сначала дорогие',
                'key' => 'sort',
                'value' => 'desc',
            ],
        ];
        return $this->render($this->view, [
            'sort' => $sort
        ]);
    }
}