<?php

namespace app\modules\short_link\models\search;

use app\modules\short_link\models\entity\ShortLinks;
use app\modules\site_settings\models\entity\SiteSettings;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class ShortLinksSearchModel extends ShortLinks
{

	public static function tableName()
	{
		return "short_links";
	}

	public function rules()
	{
		return [
			[['id'], 'integer'],
			[['short_code'], 'string'],
		];
	}

	public function scenarios()
	{
		return Model::scenarios();
	}

	public function search($params)
	{
		$query = ShortLinks::find()->orderBy(['created_at' => SORT_DESC]);

		$dataProvider = new ActiveDataProvider([
			'query' => $query,
		]);

		if (!($this->load($params) && $this->validate())) {
			return $dataProvider;
		}

		$query->andFilterWhere(['like', 'id', $this->id])
			->andFilterWhere(['like', 'short_code', $this->short_code]);

		return $dataProvider;
	}
}