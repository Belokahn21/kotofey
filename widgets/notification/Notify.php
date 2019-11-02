<?
/**
 * Developer: Konstantin Vasin by PhpStorm
 * Company: Altasib
 * Time: 15:36
 */

namespace app\widgets\notification;

use yii\base\Widget;

class Notify extends Widget
{
    public function run()
    {
        $message = "";
        $template = "";

        if (\Yii::$app->session->hasFlash('notify')) {
            $template = \Yii::$app->session->getFlash('notify');
        }

        if (\Yii::$app->session->hasFlash('notify-text')) {
            $message = \Yii::$app->session->getFlash('notify-text');
        }

        if (!empty($template) && !empty($message)) {

            $JS = <<<JS
            $(document).ready(function() {
                setTimeout(function() {
                  $(".alert-notify-wrap").slideUp();
                }, 2500);
            });
JS;

            $CSS = <<<CSS
@import url('https://fonts.googleapis.com/css?family=Roboto:400,700');
body{position: relative;}
.alert-notify-wrap{position: absolute; top: 25%; left: 10%; z-index: 99999;}
    .alert-notify{width: 400px;padding: 10px; color: white; font-family: 'Roboto', sans-serif; font-weight: 700;}
        .alert-notify__type{margin: 0 2% 0 0; font-size: 18px;}
        .alert-notify__content{float: right; height: 100%; width: 70%;}
        .alert-notify__close{margin-left: 15px;color: white;font-weight: bold;float: right;font-size: 22px;line-height: 20px;cursor: pointer;transition: 0.3s;}
            .alert-notify__close:hover{color: black;}

    .success-notify{background: #8BC34A;}
    .warning-notify{background: #FFC107;}
    .error-notify{background: #F44336;}
CSS;

            \Yii::$app->view->registerCss($CSS);
            \Yii::$app->view->registerJs($JS);

            $this->clearNotify();

            return $this->render($template, [
                'message' => $message
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