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

	public static function printFile($target = null, $clear = false, $no_wrap = false)
	{

		$filePath = $_SERVER['DOCUMENT_ROOT'] . "/web/debug.txt";

		if (!empty($target)) {
			$info = null;
			if (!$no_wrap) {
				$info = '<pre>';
				$info .= print_r($target, true);
				$info .= '</pre>';
				$info .= PHP_EOL;
				$info .= "\n";
			} else {
				$info = print_r($target, true);
			}

			if ($clear === true) {
				if (is_file($filePath)) {
					unlink($filePath);
				}
			}

			file_put_contents($filePath, $info, FILE_APPEND | LOCK_EX);
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