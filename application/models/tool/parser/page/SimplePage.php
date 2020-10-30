<?php

namespace app\models\tool\parser\page;


use app\modules\site\models\tools\Debug;

class SimplePage
{
    public function content($url)
    {
        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true
        ));
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }
}