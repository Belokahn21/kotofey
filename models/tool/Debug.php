<?

namespace app\models\tool;


use app\models\entity\User;

class Debug
{
    public static function p($target)
    {
        if (!empty($target)) {
            $debugInfo = debug_backtrace()[0];

            echo "<pre>";
            echo "info: line: " . $debugInfo['line'] . " in file: " . $debugInfo['file'];
            echo "\n";
            print_r($target);
            echo "</pre>";
        }
    }

    public static function printFile($target = null, $clear = false)
    {

        $filePath = $_SERVER['DOCUMENT_ROOT'] . "/web/debug.html";

        if (!empty($target)) {
            $info = print_r($target, true);

            if ($clear === true) {
                unlink($filePath);
            }

            file_put_contents($filePath, $info . "\n", FILE_APPEND | LOCK_EX);
        }
    }
}