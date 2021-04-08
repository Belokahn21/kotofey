<?php


namespace app\modules\logger\models\service;


use app\modules\logger\models\entity\Logger;

class LogService
{
    public static function saveSuccessMessage(string $message, string $uniqCode)
    {
        self::saveMessage(Logger::STATUS_SUCCESS, $message, $uniqCode);
    }

    public static function saveErrorMessage(string $message, string $uniqCode)
    {
        self::saveMessage(Logger::STATUS_ERROR, $message, $uniqCode);
    }

    public static function saveWarningMessage(string $message, string $uniqCode)
    {
        self::saveMessage(Logger::STATUS_WARNING, $message, $uniqCode);
    }

    public static function saveMessage(int $status, string $message, string $uniqCode)
    {
        $model = new Logger();
        $model->message = $message;
        $model->uniqCode = $uniqCode;
        $model->status = $status;
        return $model->validate() && $model->save();
    }
}