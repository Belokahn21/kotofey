<?php

use yii\db\Migration;

class m210112_172515_modify_promo_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%promotion}}', 'slug', $this->string()->after('name'));
    }

    public function safeDown()
    {
    }
}
