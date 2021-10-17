<?php

use yii\db\Migration;

class m211017_045153_modify_reviews_table extends Migration
{
    public function safeUp()
    {
        $this->dropColumn('{{%reviews}}', 'email');
        $this->addColumn('{{%reviews}}', 'email', $this->string()->null());
    }

    public function safeDown()
    {
    }
}
