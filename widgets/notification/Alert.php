<?php

namespace app\widgets\notification;

use yii\base\Widget;

class Alert extends Widget
{
	public $template = 'frontend';

	public function run()
	{
		$message = "";
		$flag = "";

		if (\Yii::$app->session->hasFlash('notify')) {
			$flag = \Yii::$app->session->getFlash('notify');
		}

		if (\Yii::$app->session->hasFlash('notify-text')) {
			$message = \Yii::$app->session->getFlash('notify-text');
		}

		if (!empty($flag) && !empty($message)) {
			$this->clearNotify();

			return $this->render($this->template, [
				'message' => $message,
				'flag' => $flag
			]);
		}
	}

	public static function clearNotify()
	{
		\Yii::$app->session->removeFlash('notify');
		\Yii::$app->session->removeFlash('notify-text');
	}


	public static function setSuccessNotify($message)
	{
		\Yii::$app->session->setFlash('notify', 'success');
		\Yii::$app->session->setFlash('notify-text', $message);
	}


	public static function setWarningNotify($message)
	{
		\Yii::$app->session->setFlash('notify', 'warning');
		\Yii::$app->session->setFlash('notify-text', $message);
	}


	public static function setErrorNotify($message)
	{
		\Yii::$app->session->setFlash('notify', 'error');
		\Yii::$app->session->setFlash('notify-text', $message);
	}

}