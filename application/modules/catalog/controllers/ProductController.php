<?php

namespace app\modules\catalog\controllers;

use Yii;
use yii\web\Controller;
use app\models\tool\System;
use app\models\tool\seo\Attributes;
use app\models\tool\seo\og\OpenGraph;
use app\models\tool\seo\og\OpenGraphProduct;
use app\modules\catalog\models\entity\Category;
use app\modules\catalog\models\entity\Product;
use app\modules\catalog\models\entity\SaveProductProperties;
use app\modules\catalog\models\entity\SaveProductPropertiesValues;

class ProductController extends Controller
{
	public function actionView($id)
	{

		$product = Product::findBySlug($id);
		if (!$product instanceof Product) {
			throw new \yii\web\NotFoundHttpException("Товар не найден.");
		}


		$category = Category::findOne($product->category_id);

		if (!empty($product->seo_description)) {
			Attributes::metaDescription($product->seo_description);
		} else {
			if (!empty($product->description)) {
				Attributes::metaDescription($product->description);
			} else {
				Attributes::metaDescription(sprintf('В нашем интернет-магазине зоотоваров в продаже  имеется %s по низкой цене в Барнауле. За каждую покупку выполучите 5%% бонусов, а мы доставим бесплатно!', $product->name));
			}
		}

		if (!empty($product->seo_keywords)) {
			Attributes::metaKeywords($product->seo_keywords);
		} else {
			Attributes::metaKeywords(explode(';', sprintf("купить %s в барнауле;интернет-зоомагазин;зоомагазин интернет барнаул;анго зоомагазин интернет барнаул;интернет зоомагазин с доставкой", $product->name)));
		}

		Attributes::canonical(System::protocol() . "://" . System::domain() . "/product/" . $product->slug . "/");


		OpenGraphProduct::title($product->display);
		if (!empty($product->description)) {
			OpenGraph::description($product->description);
			Attributes::metaDescription($product->description);
		}
		OpenGraphProduct::type();
		OpenGraphProduct::url(System::protocol() . "://" . System::domain() . "/" . Yii::$app->controller->action->id . "/" . $product->slug . "/");
		OpenGraphProduct::amount($product->price);
		OpenGraphProduct::currency('RUB');

		if (!empty($product->image)) {
			OpenGraphProduct::image(System::protocol() . "://" . System::domain() . '/web/upload/' . $product->image);
		}

		$properties = SaveProductPropertiesValues::find()->where(['product_id' => $product->id])->andWhere(['not in', 'property_id', SaveProductProperties::find()->select('id')->where(['need_show' => 0])])->all();


		return $this->render('view', [
			'product' => $product,
			'category' => $category,
			'properties' => $properties
		]);
	}
}