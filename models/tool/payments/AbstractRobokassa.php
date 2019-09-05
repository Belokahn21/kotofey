<?
/**
 * Developer: Konstantin Vasin by PhpStorm
 * Company: Altasib
 * Time: 13:35
 */

namespace app\models\tool\payments;


use app\models\tool\Debug;
use app\models\tool\payments\config\AbstractRoboConfig;
use app\models\tool\System;

abstract class AbstractRobokassa
{
    private $url = 'https://auth.robokassa.ru/Merchant/Index.aspx';
    private $urlCalcSumm = "https://auth.robokassa.ru/Merchant/WebService/Service.asmx/CalcOutSumm";

    public $login;
    public $password1;
    public $invID;
    public $invDescription;
    public $sum;
    public $isTest;
    public $crc;

    /* @var $config AbstractRoboConfig */
    public $config;

    abstract public function __construct();

    public function generateUrl()
    {

        if ($curl = curl_init()) {
            curl_setopt($curl, CURLOPT_URL, $this->urlCalcSumm . "?" . http_build_query(array(
                    "MerchantLogin" => $this->config->getLogin(),
                    "IncCurrLabel" => "QCardR",
                    "IncSum" => $this->config->getSum(),
                )));
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $out = curl_exec($curl);
            curl_close($curl);
        }
        $xml = new \SimpleXMLElement($out);

        if ($xml->OutSum) {
            $this->config->setSum(floatval($xml->OutSum));
        }

        $this->setCrc();

        $params = [
            'MerchantLogin' => $this->config->getLogin(),
            'OutSum' => $this->config->getSum(),
            'InvoiceID' => $this->config->getInvID(),
            'Description' => $this->config->getDescription(),
            'SignatureValue' => $this->crc,
            'IncCurrLabel' => 'QCardR',
        ];


        Debug::printFile($params);

        if ($this->config->getIsTest() === true) {
            $params = array_merge($params, [
                'IsTest' => '1'
            ]);
        }

        $paramsAsString = http_build_query($params);

        return $this->url . "?" . $paramsAsString;
    }

    public function setCrc()
    {
        $this->crc = md5(sprintf("%s:%s:%s:%s", $this->config->getLogin(), $this->config->getSum(), $this->config->getInvID(), $this->config->getPassword()));
    }
}