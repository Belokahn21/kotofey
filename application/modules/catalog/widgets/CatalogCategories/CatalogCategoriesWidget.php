<?php

namespace app\modules\catalog\widgets\CatalogCategories;


use yii\base\Widget;

class CatalogCategoriesWidget extends Widget
{
    public $view = 'default';
    public $category;

    public function run()
    {
        return $this->render($this->view, [
            'category' => $this->category
        ]);
    }
}