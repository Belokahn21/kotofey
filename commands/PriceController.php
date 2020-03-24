<?php

namespace app\commands;


use app\models\tool\import\RoyalCanin;
use app\models\tool\import\Valta;
use app\models\tool\import\Purina;
use yii\console\Controller;

class PriceController extends Controller
{
    public function actionUpdate($vendor = null, $external_type = null)
    {
        switch ($vendor) {
            case 1:
                $royal = new RoyalCanin();
//                $royal->setIsUpdateVendor(true);
                $royal->update();
                break;
            case 2:
                $purina = new Purina();
                $purina->update($external_type);
                break;
            default:
                echo "Выберите прайс для обновления.\n\n1 - Royal Canin\n\nphp yii price/update n";
                break;
        }
    }


    public function actionLoad($vendor = null)
    {
        switch ($vendor) {
            case 1:
//				$royal = new RoyalCanin();
//				$royal->setIsUpdateVendor(true);
//				$royal->import();
                break;

            case 2:
                $valta = new Valta();
                $valta->import();
                break;
            default:
                echo "Выберите прайс для обновления.\n\n1 - Royal Canin\n\nphp yii price/load n";
                break;
        }
    }
}