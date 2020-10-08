<?php

namespace app\modules\site\console;


use app\models\tool\Backup;
use yii\console\Controller;

class BackupController extends Controller
{
    public function actionSave()
    {
        $backup = new Backup();
        if ($backup->isOverSize()) {
            $backup->clearDumpCatalog();
        }

        $backup->createDumpDatabase();
    }
}