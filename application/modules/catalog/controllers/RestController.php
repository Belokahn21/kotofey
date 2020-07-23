<?php

namespace app\modules\catalog\controllers;


use app\models\forms\CatalogFilter;
use app\modules\catalog\models\entity\Product;
use yii\helpers\Json;
use yii\rest\Controller;

class RestController extends Controller
{

    protected function verbs()
    {
        return [
            'get' => ['POST'],
        ];
    }

	public function actionGet()
	{
	    $catalogFilter = new CatalogFilter();

	    if($catalogFilter->load(\Yii::$app->request->post())){
	        echo rand();
        }

		$products = Product::find()->all();
		return Json::encode($products);
	}
}