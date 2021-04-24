<?php


namespace app\modules\bonus\widgets\UserBonusHistory;

use Yii;
use yii\base\Widget;
use app\modules\bonus\models\entity\UserBonusHistory;

class UserBonusHistoryWidget extends Widget
{
    public $view = 'default';
    public $date_format = 'd.m.Y';

    public function run()
    {
        $models = UserBonusHistory::find()->where(['bonus_account_id' => Yii::$app->user->identity->phone])->orderBy(['created_at' => SORT_DESC])->all();
        return $this->render($this->view, [
            'models' => $models,
            'date_format' => $this->date_format
        ]);
    }
}