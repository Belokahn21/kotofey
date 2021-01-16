<?php

use yii\db\Migration;

class m210116_131103_modify_bonus_history_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%user_bonus_history}}', 'is_active', $this->boolean()->defaultValue(1)->after('id'));
        $this->addColumn('{{%user_bonus_history}}', 'sort', $this->integer()->defaultValue(500)->after('is_active'));
    }

    public function safeDown()
    {
    }
}
