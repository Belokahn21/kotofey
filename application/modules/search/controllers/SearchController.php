<?php

namespace app\modules\search\controllers;

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
        $model->save_history = true;

        if ($model->load(\Yii::$app->request->get())) {

            $query = $model->search();
            $countQuery = clone $query;

            if ($sortValue = \Yii::$app->request->get('sort')) {
                $query->orderBy(['price' => $sortValue == 'asc' ? SORT_ASC : SORT_DESC]);
            }

            $pagerItems = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 21]);
            $products = $query->offset($pagerItems->offset)->limit($pagerItems->limit)->all();

        }

        return $this->render('index', [
            'products' => $products,
            'pagerItems' => $pagerItems,
        ]);

    }
}
