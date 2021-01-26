<?php

namespace app\modules\catalog\controllers;

use Yii;
use app\models\forms\CatalogFilter;
use app\models\tool\seo\Attributes;
use app\modules\site\models\tools\System;
use app\modules\catalog\models\entity\ProductCategory;
use app\modules\catalog\models\entity\Product;
use app\modules\short_link\models\entity\ShortLinks;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;
use yii\web\Controller;

class CatalogController extends Controller
{

    public function actionIndex($id = null)
    {
        // need reidrect?
        $link = ShortLinks::findOne(['short_code' => $id]);
        if ($link) {

            $link->visits += 1;
            $link->update();

            return $this->redirect($link->link, 301);
        }

        $filterModel = new CatalogFilter();
        $category = ProductCategory::findBySlug($id);
        $sb = [];
        if ($category) {
            $sb = $category->subsections();
        }
        if ($id) {
            $query = Product::find()->orderBy(['created_at' => SORT_DESC]);

            if ($sb) {
                $query->where(['category_id' => ArrayHelper::getColumn($sb, 'id')]);
            }

            $query->andWhere(['status_id' => Product::STATUS_ACTIVE]);
        } else {
            $query = Product::find()->orderBy(['created_at' => SORT_DESC])->andWhere(['status_id' => Product::STATUS_ACTIVE]);
        }

        if ($sortValue = Yii::$app->request->get('sort')) {
            $query->orderBy(['price' => $sortValue == 'desc' ? SORT_DESC : SORT_ASC]);
        }

        $filterModel->applyFilter($query);
        $countQuery = clone $query;
        $pagerItems = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 12]);
        $pagerItems->pageSizeParam = false;
        $products = $query->offset($pagerItems->offset)->limit($pagerItems->limit)->all();

        if (!empty($category->seo_keywords)) {
            $keywords = $category->seo_keywords;
        } else {
            $keywords = [
                "зоотовары каталог",
                "каталог магазина зоотоваров",
                "валта зоотовары каталог",
                "магазин зоотоваров",
                "интернет магазин зоотоваров",
                "купить зоотовары в интернет магазине",
                "магазин зоотоваров барнаул",
                "зоотовары интернет магазин барнаул",
                "альф барнаул зоотовары",
            ];
        }

        if (!empty($category->seo_description)) {
            $description = $category->seo_description;
        } else {
            $description = "Большой выбор товара в наличии корма для домашних животных. Бесплатная доставка по городу Баранул при заказе от 500 рублей.";
        }

        if ($category) {
            $canonical = System::protocol() . "://" . System::domain() . "/catalog/" . $category->slug . "/";
        } else {
            $canonical = System::protocol() . "://" . System::domain() . "/catalog/";
        }
        Attributes::metaDescription($description);
        Attributes::metaKeywords($keywords);
        Attributes::canonical($canonical);

        return $this->render('index', [
            'pagerItems' => $pagerItems,
            'products' => $products,
            'category' => $category,
            'display' => \Yii::$app->request->get('display','list'),
        ]);
    }
}