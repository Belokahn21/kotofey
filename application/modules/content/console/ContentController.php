<?php


namespace app\modules\content\console;


use app\modules\content\models\entity\SlidersImages;
use yii\console\Controller;

class ContentController extends Controller
{
    public function actionClean()
    {
        SlidersImages::deleteAll(['<', 'end_at', time()]);
    }
}