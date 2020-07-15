<?php

namespace app\modules\search\widges\search;


use app\modules\search\models\entity\Search;
use yii\base\Widget;

class SearchWidget extends Widget
{
	public $view = 'default';

	public function run()
	{
		$model = new Search();
		return $this->render($this->view, [
			'model' => $model
		]);
	}
}