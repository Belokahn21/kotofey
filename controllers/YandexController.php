<?php

namespace app\controllers;

use Yii;
use app\models\entity\Product;
use yii\web\Controller;

class YandexController extends Controller
{
    public $layout = false;

    public function actionExport()
    {
//        \Yii::$app->response->format = \yii\web\Response::FORMAT_XML;

        $xml = new \SimpleXMLElement('<xml/>');

        for ($i = 1; $i <= 8; ++$i) {
            $track = $xml->addChild('track');
            $track->addChild('path', "song$i.mp3");
            $track->addChild('title', "Track $i - Track Title");
        }


        Header('Content-type: text/xml');
        return $xml->asXML();
    }
}