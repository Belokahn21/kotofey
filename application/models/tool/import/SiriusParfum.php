<?php


namespace app\models\tool\import;

use app\modules\catalog\models\entity\Offers;
use app\modules\catalog\models\helpers\OfferHelper;
use app\modules\site\models\tools\Debug;
use app\modules\site_settings\models\helpers\MarkupHelpers;

class SiriusParfum
{
    const VENDOR_ID = 5;

    public function getPricePath()
    {
        return \Yii::getAlias('@app/tmp/price/sirius/sirius.csv');
    }

    public function update()
    {
        if (($handle = fopen($this->getPricePath(), "r")) !== false) {
            while (($line = fgetcsv($handle, 1000, ";")) !== false) {
                $code = $line[0];
                $purchase = round(str_replace(',', '.', str_replace(' ', '', $line[3])));
                if (!is_numeric($code) || !is_numeric($purchase)) continue;
                if (!$product = Offers::find()->where(['vendor_id' => self::VENDOR_ID, 'code' => $code])->one()) continue;
                $product->scenario = Offers::SCENARIO_UPDATE_PRODUCT;
                $oldMarkup = OfferHelper::getMarkup($product);
                $product->purchase = round($purchase);
                MarkupHelpers::applyMarkup($product, $oldMarkup);

                if ($product->validate() && $product->update()) Debug::p($product->name);
            }
        }
    }
}