<?php

namespace app\modules\delivery\models\service;

use app\modules\catalog\models\helpers\PropertiesHelper;
use app\modules\delivery\models\service\delivery\tariffs\services\ProvideTariff;
use app\modules\site\models\tools\Debug;
use yii\helpers\ArrayHelper;

class DeliveryService
{
    private $products;

    public function __construct(array $products)
    {
        $this->products = $products;
    }

    public function availableTariffs($post_data)
    {
        if ($this->checkWeight()) {
            $module = \Yii::$app->getModule('delivery');
            $mass = 0;
            $dimensions = [];
            foreach ($this->products as $product) {
                $mass_tmp = PropertiesHelper::getProductWeight($product->id);
                $height = ArrayHelper::getValue(PropertiesHelper::extractPropertyById($product, PropertiesHelper::PROPERTY_HEIGHT), 'value', 0);
                $width = ArrayHelper::getValue(PropertiesHelper::extractPropertyById($product, PropertiesHelper::PROPERTY_WEIGHT), 'value', 0);
                $length = ArrayHelper::getValue(PropertiesHelper::extractPropertyById($product, PropertiesHelper::PROPERTY_LENGTH), 'value', 0);

                $mass += $mass_tmp;

                $dimensions[] = [
                    'weight' => $mass_tmp,
                    'width' => $width,
                    'height' => $height,
                    'length' => $length,
                ];
            }

            $dcs = new DeliveryCalculateService($post_data['service']);
            $tariff = new ProvideTariff();

            $tariff_params = [
                'service' => $post_data['service'],
                'placement_from' => $module->default_index_from,
                'placement_to' => $post_data['index_to'],
                'mass' => $mass * 1000,
                'dimension' => $dimensions
            ];


            $tariffData = $dcs->getPriceInfo($tariff->make($tariff_params));
            return $tariffData;
        }
    }

    private function checkWeight()
    {
        foreach ($this->products as $product) {
            $weight = PropertiesHelper::extractPropertyById($product, PropertiesHelper::PROPERTY_WEIGHT);
            if (empty($weight)) return false;
        }

        return true;
    }

    private function checkSize()
    {
        foreach ($this->products as $product) {
            $width = PropertiesHelper::extractPropertyById($product, PropertiesHelper::PROPERTY_WIDTH);
            $height = PropertiesHelper::extractPropertyById($product, PropertiesHelper::PROPERTY_HEIGHT);
            $length = PropertiesHelper::extractPropertyById($product, PropertiesHelper::PROPERTY_LENGTH);

            if (empty($width) || empty($height) || empty($length)) return false;
        }


        return true;
    }
}