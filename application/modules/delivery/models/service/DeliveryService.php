<?php

namespace app\modules\delivery\models\service;

use app\modules\catalog\models\helpers\PropertiesHelper;
use app\modules\delivery\models\service\delivery\tariffs\services\ProvideTariff;
use app\modules\site\models\tools\Debug;

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
            foreach ($this->products as $product) {
                $mass += PropertiesHelper::getProductWeight($product->id);
            }

            $dcs = new DeliveryCalculateService(DeliveryCalculateService::SERVICE_RU_POST);
            $tariff = new ProvideTariff();
            $tariff = $dcs->getPriceInfo($tariff->make([
                'service' => DeliveryCalculateService::SERVICE_RU_POST,
                'index_from' => $module->default_index_from,
                'index_to' => $post_data['index_to'],
                'mass' => $mass,
            ]));

            Debug::p($tariff);
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