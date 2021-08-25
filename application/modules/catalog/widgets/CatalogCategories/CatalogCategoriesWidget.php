<?php

namespace app\modules\catalog\widgets\CatalogCategories;


use app\modules\catalog\models\entity\ProductCategory;
use yii\base\Widget;

class CatalogCategoriesWidget extends Widget
{
    public $view = 'default';
    public $select;
    public $where;
    public $cache_key = 'CatalogCategoriesWidget';

    public function run()
    {
        $select = $this->select;
        $where = $this->where;

        $categories = \Yii::$app->cache->getOrSet($this->cache_key, function () use ($select, $where) {
            $query = ProductCategory::find()->orderBy(['sort' => SORT_DESC]);

            if ($select) $query->select($select);
            if ($where != null) $query->andWhere($where);

            return $query->all();
        });

        return $this->render($this->view, [
            'categories' => $categories
        ]);
    }
}