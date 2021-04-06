<?php

namespace app\modules\acquiring\models\services\fiscalisation\models;


use app\modules\site\models\helpers\ModuleSettingsHelper;
use yii\helpers\Json;

class OFDApi
{
    const URL = 'https://ferma.ofd.ru/api/kkt/cloud/';

    const ACTION_CREATE_CHECK = 'receipt';

    public function sendCheck()
    {
        $params = [
            'Inn' => ModuleSettingsHelper::getValue('acquiring', 'inn'),
            'Type' => 'income',
        ];

        $this->send(self::ACTION_CREATE_CHECK, $params);
    }

    public function send($action, $data = [], $headers = [])
    {
        if ($curl = curl_init()) {
            curl_setopt($curl, CURLOPT_URL, self::URL . $action);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POST, true);

            if ($data) curl_setopt($curl, CURLOPT_POSTFIELDS, Json::encode($data));


            $out = curl_exec($curl);
            echo $out;
            curl_close($curl);
        }
    }
}