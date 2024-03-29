<?php

namespace app\modules\user\models\search;

use app\modules\catalog\models\entity\Product;
use app\modules\user\models\entity\User;
use app\modules\rbac\models\entity\AuthItem;
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