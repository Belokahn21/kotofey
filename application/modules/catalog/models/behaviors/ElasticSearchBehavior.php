<?php

namespace app\modules\catalog\models\behaviors;


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
        $product = $this->owner;

        $elastic = new ProductElastic();
        $elastic->_id = $product->id;
        $elastic->id = $product->id;
        $elastic->name = $product->name;
        $elastic->insert();


    }

    public function afterUpdate()
    {

    }

    public function afterDelete()
    {
    }
}