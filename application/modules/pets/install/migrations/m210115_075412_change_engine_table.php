<?php

use yii\db\Migration;

class m210115_075412_change_engine_table extends Migration
{
    public function safeUp()
    {
        $this->execute('ALTER TABLE `animal` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;');
    }

    public function safeDown()
    {

    }
}
