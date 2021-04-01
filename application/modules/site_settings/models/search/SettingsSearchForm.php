<?php

namespace app\modules\site_settings\models\search;


use app\modules\catalog\models\entity\Product;
use app\modules\site_settings\models\entity\SiteSettings;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class SettingsSearchForm extends SiteSettings
{
	public static function tableName()
	{
		return SiteSettings::tableName();
	}

	public function rules()
	{
		return [
			[['id'], 'integer'],
			[['name', 'value'], 'string'],
		];
	}

	public function scenarios()
	{
		return Model::scenarios();
	}

	public function search($params)
	{
		$query = SiteSettings::find()->orderBy(['id' => SORT_DESC]);

		$dataProvider = new ActiveDataProvider([
			'query' => $query,
		]);

		if (!($this->load($params) && $this->validate())) {
			return $dataProvider;
		}

		$query->andFilterWhere(['like', 'id', $this->id])
			->andFilterWhere(['like', 'value', $this->value])
			->andFilterWhere(['like', 'name', $this->name]);

		return $dataProvider;
	}
}