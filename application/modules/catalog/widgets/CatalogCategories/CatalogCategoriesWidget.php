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
        $parent_id = $this->parent_id;

        $categories = \Yii::$app->cache->getOrSet('catalog-categories:' . $parent_id, function () use ($parent_id) {
            return ProductCategory::find()->where(['parent' => $parent_id])->all();
        });

        return $this->render($this->view, [
            'categories' => $categories
        ]);
    }
}