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
        $query->where(['manager_id' => $this->manager_id ?: 1])
            ->andWhere('created_at >= UNIX_TIMESTAMP(LAST_DAY(:start_at) + INTERVAL 1 DAY - INTERVAL 1 MONTH) AND created_at <  UNIX_TIMESTAMP(LAST_DAY(:end_at) + INTERVAL 1 DAY)', [
                ':start_at' => $this->start_at ? date('Y-m-d', strtotime($this->start_at)) : 'CURDATE()',
                ':end_at' => $this->end_at ? date('Y-m-d', strtotime($this->end_at)) : 'CURDATE()',
            ]);

        return $this;
    }
}