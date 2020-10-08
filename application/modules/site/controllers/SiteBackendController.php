<?php

namespace app\modules\site\controllers;

use app\modules\site\models\forms\ConsoleForm;
use app\widgets\notification\Alert;
use yii\web\Controller;

class SiteBackendController extends Controller
{
    public $layout = '@app/views/layouts/admin';

    public function actionConsole()
    {
        $console = new ConsoleForm();

        if ($console->load(\Yii::$app->request->post())) {
            if ($console->validate()) {
                if ($console->run()) {
                    Alert::setSuccessNotify('Операция успешно выполнена');
                }
            }
        }

        return $this->render('console', [
            'console' => $console
        ]);
    }
}
