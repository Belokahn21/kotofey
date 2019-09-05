<?

namespace app\widgets\geo;

use app\models\tool\geo\CityDefine;
use yii\base\Widget;

class GEO extends Widget
{

    public function run()
    {
        $location = (new CityDefine())->init();

        return $this->render('default', [
            'location' => $location
        ]);
    }


}
