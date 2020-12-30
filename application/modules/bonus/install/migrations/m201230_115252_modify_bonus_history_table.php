<?php

use yii\db\Migration;

class m201230_115252_modify_bonus_history_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%user_bonus_history}}', 'order_id', $this->integer()->null()->after('count'));
    }

    public function safeDown()
    {
    }
}
