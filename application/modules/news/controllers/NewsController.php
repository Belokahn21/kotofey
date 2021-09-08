<?php

namespace app\modules\news\controllers;

use Yii;
use yii\web\Controller;
use yii\web\HttpException;
use yii\helpers\ArrayHelper;
use app\modules\news\models\entity\News;
use app\modules\site\models\tools\System;
use app\modules\seo\models\tools\og\OpenGraph;
use app\modules\seo\models\tools\Attributes;
use app\modules\news\models\entity\NewsCategory;
use app\modules\news\models\search\NewsSearchForm;

class NewsController extends Controller
{
    public function actionIndex()
    {
        $categories = NewsCategory::find()->orderBy(['sort' => SORT_ASC])->all();
        $searchModel = new NewsSearchForm();
        $models = $searchModel->search(Yii::$app->request->get());
        $models->query->andFilterWhere([
            'is_active' => 1,
        ]);
        $models->query->orderBy(['created_at' => SORT_DESC]);
        $models = $models->getModels();

        $sub_category = null;
        if ($sub_category_id = ArrayHelper::getValue(Yii::$app->request->get('NewsSearchForm'), 'category_id')) {
            $sub_category = NewsCategory::findOne($sub_category_id);
        }


        return $this->render('index', [
            'models' => $models,
            'categories' => $categories,
            'sub_category' => $sub_category,
        ]);
    }

    public function actionView($id)
    {
        $model = News::findBySlug($id);

        if (!$model || !$model->hasAccess()) new HttpException(404, 'Новость не найдена');
        if ($model->slug) Attributes::canonical(System::protocol() . "://" . System::domain() . "/" . Yii::$app->controller->action->id . "/" . $model->slug . "/");
        if ($model->seo_description) Attributes::metaDescription($model->seo_description);
        if ($model->seo_keywords) Attributes::metaKeywords($model->seo_keywords);


        OpenGraph::title($model->title);
        OpenGraph::description(((!empty($model->preview)) ? $model->preview : $model->detail));
        OpenGraph::type("new");
        OpenGraph::url(System::protocol() . "://" . System::domain() . "/" . Yii::$app->controller->action->id . "/" . $model->slug . "/");

        if (!empty($model->preview_image)) OpenGraph::image(sprintf(' % s://%s/web/upload/%s', System::protocol(), $_SERVER['SERVER_NAME'], $model->preview_image));


        $models_current_category = [];
        if ($model->category) {
            $models_current_category = News::find()->limit(5)->where(['category_id' => $model->category])->all();
        }

        $models_all = News::find()->limit(5)->all();

        return $this->render('view', [
            'model' => $model,
            'models_current_category' => $models_current_category,
            'models_all' => $models_all,
        ]);

    }
}