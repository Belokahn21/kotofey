<?php

namespace app\models\behaviors;


use app\models\tool\Debug;
use app\models\tool\vk\Market;
use app\models\tool\vk\MarketProduct;
use yii\base\Behavior;
use yii\db\BaseActiveRecord;

class SocialStore extends Behavior
{
	public $attributes;
	public $has_store;
	public $scenario;

	public function init()
	{
		if (YII_ENV != 'prod') {
			parent::init();

			if ($this->{$this->has_store} === true) {
				echo "требуется сохранить";
			}
		}
	}


	public function events()
	{
		return [
			BaseActiveRecord::EVENT_AFTER_INSERT => 'afterSave',
			BaseActiveRecord::EVENT_AFTER_UPDATE => 'afterSave',
		];
	}

	public function afterSave()
	{
		/** @var BaseActiveRecord $model */
		$model = $this->owner;
		if ($model->scenario == 'insert') {

			$product = new MarketProduct();
			$product->name = $this->name;
			$product->description = $this->description;
			$product->price = $this->price;


			$market = new Market();
			$market->add($product);
		}
	}
}