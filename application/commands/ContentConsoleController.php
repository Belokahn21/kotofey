<?php

namespace app\commands;


use app\modules\content\models\entity\SlidersImages;
use yii\console\Controller;

class ContentConsoleController extends Controller
{
	public function actionCleanSlides()
	{
		$nowUnix = time();
		$slides = SlidersImages::find()
			->where([
				'and',
				['<', 'start_at', $nowUnix],
				['<', 'end_at', $nowUnix]
			])
			->andWhere([
				'and',
				['<>', 'start_at', 0],
				['<>', 'end_at', 0]
			])
			->all();

		foreach ($slides as $slide) {
			echo $slide->text;
//			$slide->delete();
		}
	}
}