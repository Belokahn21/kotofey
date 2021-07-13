<?php

namespace app\commands;

use app\models\tool\import\Forza10;
use app\models\tool\import\Hills;
use app\models\tool\import\RoyalCanin;
use app\models\tool\import\SiriusParfum;
use app\models\tool\import\Tavela;
use app\models\tool\import\Valta;
use app\models\tool\import\Purina;
use app\modules\catalog\models\entity\Offers;
use app\modules\site_settings\models\helpers\MarkupHelpers;
use yii\console\Controller;

class PriceController extends Controller
{
    public function actionUpdate($vendor = null, $external_type = null)
    {
        $message = [
            "Royal Canin",
            "Purina",
            "Forza10",
            "Tavela",
            "Hills",
            "Sirius (Парфюм Алтай)",
        ];

        switch ($vendor) {
            case 1:
                $royal = new RoyalCanin();
                $royal->setIsUpdateVendor(true);
                $royal->update();
                break;
            case 2:
                $purina = new Purina();
                $purina->update();
                break;
            case 3:
                $forza = new Forza10();
                $forza->update();
                break;
            case 4:
                $tavela = new Tavela();
                $tavela->update();
                break;
            case 5:
                $hills = new Hills();
                $hills->update(true);
                break;
            case 6:
                $hills = new SiriusParfum();
                $hills->update();
                break;
            default:
                echo "Выберите прайс для обновления.\n" . $this->getMessage($message) . "\nphp yii price/update n";
                break;
        }
    }

    public function actionLoad($vendor = null)
    {
        $message = [
            "Valta",
        ];
        switch ($vendor) {
            case 1:
                $valta = new Valta();
                $valta->import();
                break;
            default:
                echo "Выберите прайс для добавления.\n" . $this->getMessage($message) . "\nphp yii price/load n";
                break;
        }
    }

    public function actionFast($phrase, $markup)
    {
        $models = Offers::find();

        foreach (explode(' ', $phrase) as $text_line) {
            $models->andFilterWhere([
                'or',
                ['like', 'name', $text_line],
                ['like', 'feed', $text_line]
            ]);
        }

        $models = $models->all();

        foreach ($models as $model) {
            $model->scenario = Offers::SCENARIO_UPDATE_PRODUCT;
            MarkupHelpers::applyMarkup($model, $markup);

            if ($model->validate() && $model->update()) {
                echo $model->name;
                echo PHP_EOL;
            }
        }

    }

    public function getMessage($message)
    {
        $out = "";
        $i = 1;
        foreach ($message as $item) {
            $out .= $i . " - " . $item . "\n";
            $i++;
        }
        return $out;
    }
}