<?php

namespace app\modules\statistic\widgets;


use app\modules\search\models\entity\SearchQuery;
use yii\base\Widget;

class StatisticWidget extends Widget
{
	public $view = 'default';

	public function run()
	{
		$searches = SearchQuery::find()->orderBy(['created_at' => SORT_DESC])->all();
		$lastSearch = SearchQuery::find()->orderBy(['created_at' => SORT_DESC])->limit(5)->all();



		return $this->render($this->view, [
			'searches' => $searches,
			'lastSearch' => $lastSearch
		]);
	}
}