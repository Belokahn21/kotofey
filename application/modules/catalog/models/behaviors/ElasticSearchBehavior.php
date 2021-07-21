<?php

namespace app\modules\catalog\models\behaviors;


use app\modules\catalog\models\entity\Product;
use app\modules\catalog\models\entity\virtual\ProductElastic;
use yii\base\Behavior;
use yii\db\BaseActiveRecord;

class ElasticSearchBehavior extends Behavior
{
    public function init()
    {
    }


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
        /* @var $product Product */
        $product = $this->owner;

        $elastic = new ProductElastic();
        $elastic->fillAttributes($product);
        $elastic->insert();


    }

    public function afterUpdate()
    {
        /* @var $product Product */
        $product = $this->owner;

        $elastic = ProductElastic::findOne($product->id);
        $elastic->fillAttributes($product);
        $elastic->update();
    }

    public function afterDelete()
    {
        /* @var $product Product */
        $product = $this->owner;
        $elastic = ProductElastic::findOne($product->id);
        if ($elastic) $elastic->delete();
    }
}