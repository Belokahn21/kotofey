<?
/**
 * Developer: Konstantin Vasin by PhpStorm
 * Company: Altasib
 * Time: 12:41
 */

namespace app\widgets\notify_about_error;


use app\models\forms\NotifyAboutErorrForm;
use yii\base\Widget;

class NotifyAboutError extends Widget
{
    public function run()
    {
        $model = new NotifyAboutErorrForm();
        if(\Yii::$app->request->isPost){
//            if ($model->load(\Yii::$app->request->post())) {
//                if($model->validate()){
//                    if($model->sendNotify()){
//                    }
//                }
//            }
        }

        $CSS = <<<CSS
        .notify-about-error-button{color: white; background: green; border: 0; padding: 1%;}
CSS;

        \Yii::$app->view->registerCss($CSS);
        return $this->render('default', [
            'model' => $model
        ]);
    }
}