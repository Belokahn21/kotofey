<?

namespace app\widgets\calc_porduct_delivery\models\tools\curl;


abstract class Curl
{
    abstract function exec($url, $params = array());
}