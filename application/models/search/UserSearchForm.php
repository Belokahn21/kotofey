<?php

namespace app\models\search;

use app\models\entity\Product;
use app\models\entity\User;
use app\models\rbac\AuthItem;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class UserSearchForm extends User
{

	public static function tableName()
	{
		return "user";
	}

	public function rules()
	{
		return [
			[['email'], 'string'],
			[['id'], 'integer'],
		];
	}

	public function scenarios()
	{
		return Model::scenarios();
	}

	public function search($params)
	{
		$query = User::find()->orderBy(['created_at' => SORT_DESC]);

		$dataProvider = new ActiveDataProvider([
			'query' => $query,
		]);

		if (!($this->load($params) && $this->validate())) {
			return $dataProvider;
		}

		$query->andFilterWhere(['like', 'email', $this->email])
			->andWhere(['id' => $this->id]);

		return $dataProvider;
	}
}