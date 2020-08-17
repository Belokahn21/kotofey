<?php

use yii\db\Migration;

class m200817_175840_drop_table extends Migration
{
    public function safeUp()
    {
        $this->dropTable('{{%promo}}');
    }

    public function safeDown()
    {
    }
}
