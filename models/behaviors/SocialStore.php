<?php

namespace app\models\behaviors;


use app\models\tool\Debug;
use yii\base\Behavior;

class SocialStore extends Behavior
{
	public $attributes;

	public function init()
	{
		if (YII_ENV != 'prod') {
			parent::init();


			if (!empty($this->attributes)) {
			}
		}
	}
}