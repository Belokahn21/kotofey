<?php

namespace app\modules\order\models\search;

use app\modules\order\models\entity\Order;
use app\models\entity\Product;
use app\models\rbac\AuthItem;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class OrderSearchForm extends Order
{

	public static function tableName()
	{
		return "order";
	}

	public function rules()
	{
		return [
			[['delivery', 'payment'], 'string'],
			[['paid', 'user'], 'integer'],
		];
	}

	public function scenarios()
	{
		return Model::scenarios();
	}


	public function search($params)
	{
		$query = Order::find()->orderBy(['created_at' => SORT_DESC]);

		$dataProvider = new ActiveDataProvider([
			'query' => $query,
		]);

		if (!($this->load($params) && $this->validate())) {
			return $dataProvider;
		}

		$query->andFilterWhere(['like', 'delivery_id', $this->delivery_id])
			->andFilterWhere(['like', 'payment_id', $this->payment_id]);

		return $dataProvider;
	}


}