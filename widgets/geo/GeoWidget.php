<?php

namespace app\widgets\geo;

use app\models\tool\geo\CityDefine;
use yii\base\Widget;
use app\models\entity\Geo;

class GeoWidget extends Widget
{

	public function run()
	{
		$cities = Geo::find()->where(['type' => Geo::TYPE_OBJECT_CITY, 'active' => 1])->all();
		return $this->render('default', [
			'cities' => $cities
		]);
	}


}
