<?php

namespace app\modules\catalog\models\behaviors;

use app\modules\catalog\models\services\PriceHistoryService;
use yii\base\Behavior;
use yii\db\BaseActiveRecord;

class PriceHistoryBehavior extends Behavior
{
    public function events()
    {
        return [
            BaseActiveRecord::EVENT_AFTER_INSERT => 'afterSave',
            BaseActiveRecord::EVENT_AFTER_UPDATE => 'afterUpdate',
            BaseActiveRecord::EVENT_AFTER_DELETE => 'afterDelete',
        ];
    }

    public function afterSave()
    {
        $product = $this->owner;
        PriceHistoryService::saveHistoryElement($product->id, $product->price);
    }

    public function afterUpdate()
    {
        $product = $this->owner;
        PriceHistoryService::updateHistoryElement($product->id, $product->price);
    }

    public function afterDelete()
    {
        $product = $this->owner;
        PriceHistoryService::deleteHistoryElement($product->id);
    }
}