<?php

namespace app\models\tool;


use app\models\entity\User;
use yii\db\ActiveRecord;

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
            $info = '<pre>';
            $info .= print_r($target, true);
            $info .= '</pre>';
            $info .= PHP_EOL;

            if ($clear === true) {
                unlink($filePath);
            }

            file_put_contents($filePath, $info . "\n", FILE_APPEND | LOCK_EX);
        }
    }

    public static function modelErrors($model)
    {
        $strError = '';
        if ($model instanceof ActiveRecord) {
            foreach ($model->getErrors() as $key => $errors) {
                $strError .= '<br/>' . implode(';', $errors);
            }
        }

        return $strError;
    }
}