<?php

namespace app\modules\instagram\models\tools;


use app\modules\instagram\Module;

class Instagram
{
    public static function getData()
    {
        /* @var $module Module */
        $module = \Yii::$app->getModule('instagram');
        $url = "https://graph.instagram.com/me/media?fields=id,media_type,media_url,caption,timestamp,thumbnail_url,permalink&access_token=" . $module->instagram_token;

        $instagramCnct = curl_init(); // инициализация cURL подключения
        curl_setopt($instagramCnct, CURLOPT_URL, $url); // адрес запроса
        curl_setopt($instagramCnct, CURLOPT_RETURNTRANSFER, 1); // просим вернуть результат
        $media = json_decode(curl_exec($instagramCnct)); // получаем и декодируем данные из JSON
        curl_close($instagramCnct); // закрываем соединение

        return $media;
    }
}