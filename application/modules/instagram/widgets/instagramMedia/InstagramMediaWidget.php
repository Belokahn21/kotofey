<?php

namespace app\modules\instagram\widgets\instagramMedia;


use app\models\tool\Debug;
use app\modules\instagram\models\tools\Instagram;
use yii\base\Widget;

class InstagramMediaWidget extends Widget
{
	public $view = 'default';

	public function run()
	{
		$media = Instagram::getData();

		return $this->render($this->view, [
			'media' => $media
		]);
	}
}