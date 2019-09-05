<?
/**
 * Developer: Konstantin Vasin by PhpStorm
 * Company: Altasib
 * Time: 10:08
 */

namespace app\models\tool\delivery\calc;


abstract class AbstractDellin
{
    abstract protected function curl($url, $params);

    abstract protected function paramToJson($params);
}