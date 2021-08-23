<?php

namespace app\modules\news\controllers;

use app\modules\news\models\entity\NewsCategory;
use Yii;
use app\modules\seo\models\tools\Attributes;
use app\modules\seo\models\tools\og\OpenGraph;
use app\modules\site\models\tools\System;
use app\modules\news\models\entity\News;
use yii\web\Controller;
use yii\web\HttpException;

class NewsController extends Controller
{
    public function actionIndex()
    {
        $models = News::find()->where(['is_active' => 1])->orderBy(['created_at' => SORT_DESC])->all();
        $categories = NewsCategory::find()->orderBy(['sort' => SORT_ASC])->all();

        return $this->render('index', [
            'models' => $models,
            'categories' => $categories,
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