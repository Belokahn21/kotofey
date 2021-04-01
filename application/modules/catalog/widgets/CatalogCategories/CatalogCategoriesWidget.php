<?php

namespace app\modules\catalog\widgets\CatalogCategories;


use app\modules\catalog\models\entity\ProductCategory;
use yii\base\Widget;

class CatalogCategoriesWidget extends Widget
{
    public $view = 'default';
    public $select;
    public $where;

    public function run()
    {
        $select = $this->select;
        $where = $this->where;

        // todo: ключ кеширования поправить
        $categories = \Yii::$app->cache->getOrSet('catalog-categories:' . rand(), function () use ($select, $where) {
            $query = ProductCategory::find()->orderBy(['sort' => SORT_DESC]);

            if ($select) $query->select($select);
            if ($where) $query->andFilterWhere($where);

            return $query->all();
        });

        return $this->render($this->view, [
            'categories' => $categories
        ]);
    }
}