<?php


namespace app\modules\delivery\controllers;

use yii\rest\Controller;


class TariffsRestController extends Controller
{
    public function actionCreate()
    {
        $post_data = \Yii::$app->request->post();



        // список сервисов доставок
        // товары




        /*
         * response => [
         *  cdek=>[
         *      0=>[
         *          name:'название',
         *          price:'1500',
         *      ]
         *  ]
         * ]
         * */

        return rand();
    }
}