<?php

use yii\db\Migration;

class m210621_094532_modify_stock_table extends Migration
{
    public function safeUp()
    {
        $this->dropColumn('{{%stocks}}', 'time_start');
        $this->dropColumn('{{%stocks}}', 'time_end');

        $this->addColumn('{{%stocks}}', 'time_start', $this->time()->after('city_id'));
        $this->addColumn('{{%stocks}}', 'time_end', $this->time()->after('time_start'));
    }

    public function safeDown()
    {
    }
}
