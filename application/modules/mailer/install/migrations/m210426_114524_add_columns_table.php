<?php

use yii\db\Migration;


class m210426_114524_add_columns_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%mail_templates}}', 'from', $this->string(128)->after('name'));
        $this->addColumn('{{%mail_templates}}', 'to', $this->string(128)->after('name'));
    }

    public function safeDown()
    {
        $this->dropColumn('{{%mail_templates}}', 'from');
        $this->dropColumn('{{%mail_templates}}', 'to');
    }
}
