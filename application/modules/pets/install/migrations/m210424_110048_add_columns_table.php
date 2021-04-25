<?php

use yii\db\Migration;

class m210424_110048_add_columns_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%pets}}', 'sex_id', $this->integer()->after('name'));
        $this->addColumn('{{%pets}}', 'avatar', $this->string()->after('name'));
        $this->addColumn('{{%pets}}', 'status_id', $this->integer()->after('id'));
    }

    public function safeDown()
    {
        $this->dropColumn('{{%pets}}', 'sex_id');
        $this->dropColumn('{{%pets}}', 'avatar');
        $this->dropColumn('{{%pets}}', 'status_id');
    }
}
