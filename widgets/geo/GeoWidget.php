<?

namespace app\widgets\geo;

use app\models\tool\geo\CityDefine;
use yii\base\Widget;
use app\models\entity\Geo;

class GeoWidget extends Widget
{

	public function run()
	{
		$location = (new CityDefine())->init();
		$cities = Geo::find()->where(['type' => Geo::TYPE_OBJECT_CITY])->all();

		return $this->render('default', [
			'location' => $location,
			'cities' => $cities
		]);
	}


}
