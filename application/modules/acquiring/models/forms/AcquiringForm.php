<?php


namespace app\modules\acquiring\models\forms;


use yii\base\Model;

class AcquiringForm extends Model
{
    public $transaction_id;
    public $action;

    const ACTION_ROLLBACK_PAY = 1;
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
}