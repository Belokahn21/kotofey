<?php

use yii\db\Migration;

class m200930_150000_modify_logger_table extends Migration
{
    public function safeUp()
    {
        $this->execute('alter table `logger` convert to character set utf8 collate utf8_general_ci;');
    }

    public function safeDown()
    {
    }
}
