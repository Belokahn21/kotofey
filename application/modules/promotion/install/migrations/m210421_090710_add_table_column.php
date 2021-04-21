<?php

use yii\db\Migration;

class m210421_090710_add_table_column extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%promotion}}', 'sort', $this->integer()->defaultValue(500)->after('id'));
    }

    public function safeDown()
    {
        $this->dropColumn('{{%promotion}}', 'sort');
    }
}
