<?php

use yii\db\Migration;

class m211027_035500_modify_marketplace_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%marketplace}}', 'type_export_id', $this->integer()->after('id'));
    }

    public function safeDown()
    {
    }
}
