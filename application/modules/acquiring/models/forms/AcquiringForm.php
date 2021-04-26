<?php


namespace app\modules\acquiring\models\forms;


use app\modules\acquiring\models\entity\AcquiringOrder;
use app\modules\payment\models\services\acquiring\auth\SberbankAuthBasic;
use app\modules\payment\models\services\acquiring\banks\Sberbank;
use app\modules\payment\models\services\acquiring\AcquiringTerminalService;
use yii\base\Model;

class AcquiringForm extends Model
{
    public $transaction_id;
    public $action;

    const ACTION_ROLLBACK_MONEY = 1;
    const ACTION_CANCEL_PAY = 2;

    public function rules()
    {
        return [
            ['action', 'string'],
            ['transaction_id', 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'action' => 'Выполнить действие',
            'transaction_id' => 'ID транзакции',
        ];
    }

    public function getActions()
    {
        return [
            self::ACTION_ROLLBACK_MONEY => 'Вернуть деньги',
            self::ACTION_CANCEL_PAY => 'Отменить оплату',
        ];
    }


    public function doAction()
    {
        $result = true;
        // сервис выполняющий по банку операции в зависимости от банка ещё
        // бизнес процессы

        $bank = new Sberbank(new SberbankAuthBasic(\Yii::$app->params['acquiring']['sberbank']['login'], \Yii::$app->params['acquiring']['sberbank']['password']));

        $terminal = new AcquiringTerminalService($bank);
        $model = AcquiringOrder::findOne($this->transaction_id);


        switch ($this->action) {
            case self::ACTION_ROLLBACK_MONEY:
                $terminal->rollbackMoney($model);
                break;
            case self::ACTION_CANCEL_PAY:
                $terminal->cancelPay($model);
                break;
        }

        return $result;
    }
}