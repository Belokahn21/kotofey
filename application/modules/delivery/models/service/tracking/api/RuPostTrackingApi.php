<?php


namespace app\modules\delivery\models\service\tracking\api;


use SoapClient;
use SoapParam;

class RuPostTrackingApi implements TrackingApi
{

    public function getOrderInfo(string $track_id)
    {
        $module = \Yii::$app->getModule('delivery');

        if (empty($module->ru_post_login) || empty($module->ru_post_password)) return false;

        $wsdlurl = 'https://tracking.russianpost.ru/rtm34?wsdl';

        $client = new SoapClient($wsdlurl, array('trace' => 1, 'soap_version' => SOAP_1_2));

        $params = array(
            'OperationHistoryRequest' => array('Barcode' => $track_id, 'MessageType' => '0', 'Language' => 'RUS'),
            'AuthorizationHeader' => array('login' => $module->ru_post_login, 'password' => $module->ru_post_password)
        );

        $result = $client->getOperationHistory(new SoapParam($params, 'OperationHistoryRequest'));

        \app\modules\site\models\tools\Debug::p($result);

        exit();
    }
}