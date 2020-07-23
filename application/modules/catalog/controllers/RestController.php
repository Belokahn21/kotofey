<?php

namespace app\modules\catalog\controllers;


use yii\helpers\Json;
use yii\rest\Controller;

class RestController extends Controller
{
	public function actionGet()
	{
		return Json::encode();
	}
}