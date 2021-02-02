<?php

namespace app\modules\favorite\controllers;

use Yii;
use yii\web\Controller;
use app\modules\site\models\tools\System;
use app\modules\seo\models\tools\Attributes;
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
