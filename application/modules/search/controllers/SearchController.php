<?php

namespace app\modules\search\controllers;

use app\models\forms\CatalogFilter;
use yii\web\Controller;
use yii\data\Pagination;
use app\modules\search\models\entity\Search;

class SearchController extends Controller
{
    public function actionIndex()
    {
        $pagerItems = array();
        $products = array();
        $model = new Search();
        $searchFilter = new CatalogFilter();
        $model->save_history = true;

        if ($model->load(\Yii::$app->request->get())) {

            $query = $model->search();
            $duplicateQueryProducts = clone $query;

            if ($sortValue = \Yii::$app->request->get('sort')) $query->orderBy(['price' => $sortValue == 'asc' ? SORT_ASC : SORT_DESC]);
            $searchFilter->applyFilter($query);

            $pagerItems = new Pagination(['totalCount' => $query->count(), 'pageSize' => 21]);
            $products = $query->offset($pagerItems->offset)->limit($pagerItems->limit)->all();
        }

        return $this->render('index', [
            'products' => $products,
            'pagerItems' => $pagerItems,
            'duplicateQueryProducts' => $duplicateQueryProducts,
        ]);

    }
}
