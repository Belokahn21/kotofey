<?php

namespace app\commands;

use app\modules\catalog\models\entity\Price;
use app\modules\catalog\models\entity\PriceProduct;
use app\modules\catalog\models\entity\Product;
use app\modules\pets\models\entity\Animal;
use app\modules\pets\models\entity\Breed;
use app\modules\pets\models\entity\Pets;
use app\modules\site\models\tools\Debug;
use yii\console\Controller;

class ConsoleController extends Controller
{
    public function actionRun()
    {

        foreach ((new Breed())->getSizes() as $key => $value) {
            $dom = new \DOMDocument();
            $dom->loadHTML(file_get_contents(\Yii::getAlias("@app/tmp/{$key}.html")), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD | LIBXML_NOERROR | LIBXML_NOWARNING);

            $xpath = new \DOMXPath($dom);
            foreach ($xpath->query('//h5[@class="new_name"]') as $name) {
                $name = $name->nodeValue;
                $name = trim($name);

                $breed = Breed::find()->where(['like', 'name', $name])->one();
                if ($breed) {
                    $breed->size = $key;
                    if ($breed->validate() && $breed->update() !== false) {
                        echo $breed->name . PHP_EOL;
                    }
                }
            }
        }
    }

    public function actionClearCache()
    {
        \Yii::$app->cache->flush();
    }
}
