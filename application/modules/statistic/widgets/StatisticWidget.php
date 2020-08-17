<?php

namespace app\modules\statistic\widgets;


use app\modules\search\models\entity\SearchQuery;
use yii\base\Widget;

class StatisticWidget extends Widget
{
	public $view = 'default';

	public function run()
	{
		$searches = SearchQuery::find()->all();
		$lastSearch = SearchQuery::find()->limit(5)->all();
		return $this->render($this->view, [
			'searches' => $searches,
			'lastSearch' => $lastSearch
		]);
	}
}