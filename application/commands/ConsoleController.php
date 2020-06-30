<?php

namespace app\commands;

use yii\console\Controller;

class ConsoleController extends Controller
{
	public function actionRun()
	{
	}

	public function actionClearCache()
	{
		\Yii::$app->cache->flush();
	}
}
