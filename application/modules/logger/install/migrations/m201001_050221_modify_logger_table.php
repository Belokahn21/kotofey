<?php

use yii\db\Migration;

class m201001_050221_modify_logger_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%logger}}', 'status', $this->integer()->defaultValue(200)->notNull()->after('message'));
    }

    public function safeDown()
    {
        $this->dropColumn('{{%logger}}', 'status');
    }
}
