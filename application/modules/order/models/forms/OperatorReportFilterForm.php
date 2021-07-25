<?php

namespace app\modules\order\models\forms;

use yii\base\Model;
use yii\db\ActiveQuery;

class OperatorReportFilterForm extends Model
{
    public $start_at;
    public $end_at;
    public $manager_id;

    public function rules()
    {
        return [
            [['start_at', 'end_at'], 'string'],

            [['manager_id'], 'integer']
        ];
    }

    public function attributeLabels()
    {
        return [
            'start_at' => 'Начало даты',
            'end_at' => 'Конец даты',
            'manager_id' => 'Менеджер',
        ];
    }

    public function applyFilter(ActiveQuery &$query)
    {
        $query->where(['manager_id' => $this->manager_id ?: 1, 'is_paid' => 1, 'is_close' => 1])
            ->andWhere('created_at >= :start_at AND created_at <  :end_at', [
                ':start_at' => $this->start_at ? strtotime($this->start_at) : null,
                ':end_at' => $this->end_at ? strtotime($this->end_at) : null,
            ]);
    }
}