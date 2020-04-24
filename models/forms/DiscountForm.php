<?php

namespace app\models\forms;


use app\models\entity\Discount;
use app\modules\order\models\entity\Order;
use app\models\tool\Debug;
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
		if ($this->discount == 0) {
			return true;
		}

		$user_discount = Discount::findByUserId(\Yii::$app->user->id);
		if ($this->discount > $user_discount->count) {
			return false;
		}

		$user_discount->count -= $this->discount;
		if ($user_discount->update() === false) {
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