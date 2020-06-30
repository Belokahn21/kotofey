<?php

namespace app\commands;

use yii\console\Controller;

class ConsoleController extends Controller
{
	public function actionRun()
	{
		\Yii::$app->db->createCommand('drop table providers;');
	}

	public function actionClearCache()
	{
		\Yii::$app->cache->flush();
	}
}
