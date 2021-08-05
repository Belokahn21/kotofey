<?php

namespace app\commands;

use app\modules\pets\models\entity\Animal;
use app\modules\pets\models\entity\Breed;
use app\modules\site\models\tools\Debug;
use yii\console\Controller;

class ConsoleController extends Controller
{
    public function actionRun()
    {
        $html = file_get_contents(\Yii::getAlias('@app') . '/tmp/cats.html');

        $dom = new \DOMDocument();
        $dom->loadHTML($html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD | LIBXML_NOERROR | LIBXML_NOWARNING);

        $xpath = new \DOMXPath($dom);
        $names = $xpath->query('//p[@class="has-text-align-center"]/a');


        foreach ($names as $dog_name) {
            $breed = new Breed();
            $breed->name = $dog_name->nodeValue;
            $breed->animal_id = Animal::TYPE_CAT_ID;

            if ($breed->validate() && $breed->save()) echo $dog_name->nodeValue . PHP_EOL;
        }


    }

    public function actionClearCache()
    {
        \Yii::$app->cache->flush();
    }
}
