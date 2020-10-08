<?php

namespace app\models\forms;


use yii\base\Model;

class SaleProductForm extends Model
{
	public $sale_id;

	public function rules()
	{
		return [
			['sale_id', 'required'],
			['sale_id', 'integer']
		];
	}

	public function attributeLabels()
	{
		return [
			'sale_id' => 'ID акции',
		];
	}
}