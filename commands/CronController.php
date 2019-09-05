<?

namespace app\commands;

use app\models\tool\Backup;
use yii\console\Controller;
use yii\console\ExitCode;

class CronController extends Controller
{
    public function actionIndex()
    {
        $backup = new Backup();

        if($backup->checkLimitSize()){
            $backup->clearDumpCatalog();
        }

        $backup->createDumpDatabase();

        return ExitCode::OK;
    }
}
