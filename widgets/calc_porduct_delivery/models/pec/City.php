<?

namespace app\widgets\calc_porduct_delivery\models\pec;

use yii\helpers\Json;

class City
{
    public function lists()
    {
        $pecCityList = Json::decode(file_get_contents("https://pecom.ru/ru/calc/towns.php"));
        return $pecCityList;
    }
}