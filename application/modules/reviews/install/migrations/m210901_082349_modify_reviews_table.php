<?php

use yii\db\Migration;

class m210901_082349_modify_reviews_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%reviews}}', 'phone', $this->bigInteger()->notNull());
        $this->addColumn('{{%reviews}}', 'email', $this->string()->notNull());
    }

    public function safeDown()
    {
    }
}
