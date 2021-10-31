<?php

use yii\db\Migration;

class m211031_174823_modify_marketplace_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%marketplace}}', 'shop_id', $this->bigInteger()->after('id'));
    }

    public function safeDown()
    {
    }
}
