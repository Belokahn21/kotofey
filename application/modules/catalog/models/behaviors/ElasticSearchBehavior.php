<?php

namespace app\modules\catalog\models\behaviors;


use app\modules\catalog\models\entity\Product;
use app\modules\catalog\models\entity\virtual\ProductElastic;
use app\modules\search\Module;
use yii\base\Behavior;
use yii\db\BaseActiveRecord;

class ElasticSearchBehavior extends Behavior
{
    public $module;

    public function init()
    {
        parent::init();

        $this->module = \Yii::$app->getModule('search');
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
        if ($this->module->search_engine == Module::SEARCH_ENGINE_ELASTIC) {
            /* @var $product Product */
            $product = $this->owner;

            $elastic = new ProductElastic();
            $elastic->fillAttributes($product);
            $elastic->insert();
        }
    }

    public function afterUpdate()
    {
        if ($this->module->search_engine == Module::SEARCH_ENGINE_ELASTIC) {
            /* @var $product Product */
            $product = $this->owner;

            $elastic = ProductElastic::findOne($product->id);
            if ($elastic) {
                $elastic->fillAttributes($product);
                $elastic->update();
            } else {
                $elastic = new ProductElastic();
                $elastic->fillAttributes($product);
                $elastic->insert();
            }
        }
    }

    public function afterDelete()
    {
        if ($this->module->search_engine == Module::SEARCH_ENGINE_ELASTIC) {
            /* @var $product Product */
            $product = $this->owner;
            $elastic = ProductElastic::findOne($product->id);
            if ($elastic) $elastic->delete();
        }
    }
}