<?php

namespace app\models\search;


use app\models\entity\News;
use app\models\entity\TodoList;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class TodoSearchForm extends TodoList
{

	public static function tableName()
	{
		return "todo_list";
	}

	public function rules()
	{
		return [
			[['name'], 'string'],
			[['description'], 'string'],
		];
	}

	public function scenarios()
	{
		return Model::scenarios();
	}

	public function search($params)
	{
		$query = TodoList::find()->orderBy(['created_at' => SORT_DESC]);

		$dataProvider = new ActiveDataProvider([
			'query' => $query,
			'pagination' => [
				'pageSize' => 10,
			],
		]);

		if (!($this->load($params) && $this->validate())) {
			return $dataProvider;
		}

		$query->andFilterWhere(['like', 'name', $this->name])
			->andFilterWhere(['like', 'description', $this->description]);

		return $dataProvider;
	}
}