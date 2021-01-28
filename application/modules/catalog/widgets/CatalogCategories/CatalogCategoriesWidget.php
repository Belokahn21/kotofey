<?php

namespace app\modules\catalog\widgets\CatalogCategories;


use app\modules\catalog\models\entity\ProductCategory;
use yii\base\Widget;

class CatalogCategoriesWidget extends Widget
{
    public $view = 'default';
    public $parent_id = 0;

    public function run()
    {
        $categories = ProductCategory::find()->where(['parent' => $this->parent_id])->all();

        return $this->render($this->view, [
            'categories' => $categories
        ]);
    }
}