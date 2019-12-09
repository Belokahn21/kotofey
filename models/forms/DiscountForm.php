<?php

namespace app\models\forms;


use app\models\entity\Discount;
use app\models\entity\Order;
use phpDocumentor\Reflection\Types\Integer;
use yii\base\Model;

class DiscountForm extends Model
{
	public $discount;

	public function rules()
	{
		return [
			[['discount'], 'integer', 'max' => Discount::findByUserId(\Yii::$app->user->id)->count, 'tooBig' => 'Вы не можете потратить больше {max} боунсов'],
		];
	}

	public function calc(Order &$order, $property)
	{
		if ($this->discount > Discount::findByUserId(\Yii::$app->user->id)) {
			return false;
		}

		try {
			$order->{$property} = $this->discount;
		} catch (\Exception $exception) {
			return false;
		}

		return true;
	}
}