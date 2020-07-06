<?php

namespace app\modules\content\models\behaviors;

use yii\behaviors\AttributeBehavior;
use yii\db\ActiveRecord;

class DateToIntBehaviors extends AttributeBehavior
{
	public function events()
	{
		return [
			ActiveRecord::EVENT_BEFORE_UPDATE => 'setValue',
			ActiveRecord::EVENT_BEFORE_INSERT => 'setValue',
			ActiveRecord::EVENT_AFTER_FIND => 'prepareValue',
		];
	}

	public function setValue($event)
	{
		$this->owner->start_at = (strtotime($this->owner->start_at . " 00:00:00"));
		$this->owner->end_at = (strtotime($this->owner->end_at . " 00:00:00"));
	}

	public function prepareValue($event)
	{
		$this->owner->start_at = date('d.m.Y', $this->owner->start_at);
		$this->owner->end_at = date('d.m.Y', $this->owner->end_at);
	}
}
