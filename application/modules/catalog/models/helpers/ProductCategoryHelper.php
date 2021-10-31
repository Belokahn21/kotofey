<?php

namespace app\modules\catalog\models\helpers;

use app\modules\catalog\models\entity\ProductCategory;
use app\modules\media\models\helpers\MediaHelper;
use app\modules\site\models\tools\Debug;
use yii\caching\DbDependency;
use yii\helpers\Url;

class ProductCategoryHelper
{
    private $formated_items;

    public static function getDetailUrl(ProductCategory $model)
    {
        return "/catalog/" . $model->slug . "/";
    }

    public static function getImageUrl(ProductCategory $model, $isFull = false)
    {
        if ($isFull) {
            return Url::base(true) . "/upload/" . $model->image;
        }
        return "/upload/" . $model->image;
    }

    public static function getInstance()
    {
        return new self();
    }

    public function getFormated($parent_id = 0, $delim = "")
    {
        return \Yii::$app->cache->getOrSet('formated_three_categories' . $parent_id, function () use ($parent_id, $delim) {
            $categories = ProductCategory::find()->select(['id', 'name', 'parent_category_id'])->where(['parent_category_id' => $parent_id])->all();

            if ($categories) {

                foreach ($categories as &$category) {
                    $category->name = $delim . $category->name;
                    $this->formated_items[] = $category;
                    self::getFormated($category->id, $delim . '---');
                }
            }

            return $this->formated_items;
        }, null, new DbDependency([
            'sql' => 'select max(created_at) from product_category limit 1;'
        ]));
    }

    public function getNavChain(ProductCategory $category)
    {
        return \Yii::$app->cache->getOrSet('nav-chain=' . $category->id, function () use ($category) {
            $chain = [];

            $categories = $category->childs;

            if (!$categories) $chain[] = $category;

            while ($categories) {
                foreach ($categories as $category) {
                    $chain[] = $category;
                    $categories = $category->childs;
                }
            }

            return $chain;
        });
    }

    public function getBreadcrumbs(ProductCategory $category)
    {
        return \Yii::$app->cache->getOrSet('breadcrumbs-' . $category->id, function () use ($category) {
            while ($category) {
                $breadcrumbs[] = $category;
                $category = $category->parent;
            }
            return array_reverse($breadcrumbs);
        });
    }
}