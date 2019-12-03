<?php

namespace app\models\behaviors;


use yii\base\Behavior;
use yii\db\BaseActiveRecord;

class Alert extends Behavior
{


	public function init()
	{
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
		$model = $this->owner;
	}
}