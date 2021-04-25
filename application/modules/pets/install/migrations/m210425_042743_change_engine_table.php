<?php

use yii\db\Migration;

class m210425_042743_change_engine_table extends Migration
{
    public function safeUp()
    {
        $this->execute('alter table `pets` convert to CHARACTER SET utf8 COLLATE utf8_unicode_ci;');
    }

    public function safeDown()
    {
    }
}
