<?
/**
 * Developer: Konstantin Vasin by PhpStorm
 * Company: Altasib
 * Time: 12:33
 */

namespace app\models\tool\geo;


use app\models\tool\geo\entity\GeoInfo;
use app\models\tool\System;
use yii\base\ErrorException;

class CityDefine
{

    const ID_DEFAULT_CITY = 76005; // ID Москвы

    private $execSiteUrl;
    private $curlResult;

    private $url;
    private $ip;


    public function __construct()
    {
        $this->setIp(System::getRealIpAddr());
        $this->setUrl("http://ipgeobase.ru:7020/geo");
    }


    public function init()
    {
        // Формируем ссылку для получения информации об IP
        $this->buildExecUrl();
        // Выполняем запрос
        $this->execCommand();

        if (empty($this->curlResult)) {
            throw new ErrorException("Request for get info about IP return empty value.");
        }


        $geoInfo = new GeoInfo();
        $geoInfo->load(simplexml_load_string($this->curlResult)->ip);
        return $geoInfo;

    }

    private function buildExecUrl()
    {
        return $this->execSiteUrl = $this->url . "?" . http_build_query(['ip' => $this->ip]);
    }

    private function execCommand()
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->execSiteUrl);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 3);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
        curl_setopt($ch, CURLOPT_USERAGENT, 'PHP Bot');
        $this->curlResult = curl_exec($ch);
        curl_close($ch);
    }

    public function setIp($ip)
    {
        $this->ip = $ip;
    }

    public function setUrl($url)
    {
        $this->url = $url;
    }
}