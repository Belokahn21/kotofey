<?php

use yii\db\Migration;

class m210424_110048_add_columns_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%pets}}', 'sex_id', $this->integer()->after('name'));
        $this->addColumn('{{%pets}}', 'avatar', $this->integer()->after('name'));
    }

    public function safeDown()
    {
        $this->dropColumn('{{%pets}}', 'sex_id');
        $this->dropColumn('{{%pets}}', 'avatar');
    }
}
