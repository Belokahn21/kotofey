<?php

namespace app\commands;

use yii\console\Controller;

class ConsoleController extends Controller
{
    public function actionRun()
    {
        $file = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/tmp/dogs.html');


        echo $file;
    }

    public function actionClearCache()
    {
        \Yii::$app->cache->flush();
    }
}
