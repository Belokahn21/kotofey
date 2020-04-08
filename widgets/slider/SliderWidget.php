<?php

namespace app\widgets\slider;


use app\models\entity\SlidersImages;
use yii\base\Widget;

class SliderWidget extends Widget
{
	public $slider_id;
	public $use_carousel;
	public $view = 'default';

	public function run()
	{
		$images = [];
		if (!empty($this->slider_id)) {
			$unix_now = time();
			$images = SlidersImages::find()
				->where(['slider_id' => $this->slider_id, 'active' => true])
				->andWhere([
					'and',
					['<', 'start_at', $unix_now],
					['>', 'end_at', $unix_now],
				])
				->orWhere(['start_at' => 0, 'end_at' => 0])
				->orderBy(['created_at' => SORT_DESC]);

			$images = $images->all();
		}

		return $this->render($this->view, [
			'images' => $images,
		]);
	}
}