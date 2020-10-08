<?php

use yii\db\Migration;

class m200930_092859_modify_logger_table extends Migration
{
    public function safeUp()
    {
        $this->alterColumn('{{%logger}}', 'uniqCode', $this->string(255)->notNull());
    }

    public function safeDown()
    {
        $this->alterColumn('{{%logger}}', 'uniqCode', $this->integer()->notNull());
    }
}
