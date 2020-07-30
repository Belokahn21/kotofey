<?php

namespace app\modules\news\controllers;

use Yii;
use app\models\tool\seo\Attributes;
use app\models\tool\seo\og\OpenGraph;
use app\models\tool\System;
use app\modules\news\models\entity\News;
use yii\web\Controller;

class NewsController extends Controller
{
	public function actionIndex()
	{
		$models = News::find()->all();

		return $this->render('index', [
			'models' => $models
		]);
	}

	public function actionView($id)
	{
		$new = News::findBySlug($id);
		if ($new->slug) {
			Attributes::canonical(System::protocol() . "://" . System::domain() . "/" . Yii::$app->controller->action->id . "/" . $new->slug . "/");
		}

		if ($new->seo_description) {
			Attributes::metaDescription($new->seo_description);
		}

		if ($new->seo_keywords) {
			Attributes::metaKeywords($new->seo_keywords);
		}

		OpenGraph::title($new->title);
		OpenGraph::description(((!empty($new->preview)) ? $new->preview : $new->detail));
		OpenGraph::type("new");
		OpenGraph::url(System::protocol() . "://" . System::domain() . "/" . Yii::$app->controller->action->id . "/" . $new->slug . "/");

		if (!empty($new->preview_image)) {
			OpenGraph::image(sprintf('%s://%s/web/upload/%s', System::protocol(), $_SERVER['SERVER_NAME'], $new->preview_image));
		}

		return $this->render('view', [
			'model' => $new
		]);

	}
}