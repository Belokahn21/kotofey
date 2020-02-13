<?php

namespace app\commands;


use app\models\tool\import\RoyalCanin;
use yii\console\Controller;

class PriceController extends Controller
{
	public function actionUpdate($vendor = null)
	{
		switch ($vendor) {
			case 1:
				$royal = new RoyalCanin();
				$royal->setIsUpdateVendor(true);
				$royal->import();
				break;
			default:
				echo "Выберите прайс для обновления.\n\n1 - Royal Canin\n\nphp yii price/update n";
				break;
		}
	}
}