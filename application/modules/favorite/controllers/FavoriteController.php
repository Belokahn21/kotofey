<?php

namespace app\modules\favorite\controllers;

use Yii;
use yii\web\Controller;
use app\models\tool\System;
use app\models\tool\seo\Attributes;
use app\modules\favorite\models\entity\Favorite;

class FavoriteController extends Controller
{
	public function actionIndex()
	{
		Attributes::canonical(System::protocol() . "://" . System::domain() . "/" . Yii::$app->controller->action->id . "/");
		$products = Favorite::listProducts();
		return $this->render('index', [
			'products' => $products
		]);
	}
}
