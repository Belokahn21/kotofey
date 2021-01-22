<?php

namespace app\commands;

use app\modules\site\models\tools\Backup;
use yii\console\Controller;
use yii\console\ExitCode;

class CronController extends Controller
{
    public function actionDumpbase()
    {
        $backup = new Backup();

        if($backup->isOverSize()){

            $backup->clearDumpCatalog();
        }

        $backup->createDumpDatabase();

        return ExitCode::OK;
    }
}
