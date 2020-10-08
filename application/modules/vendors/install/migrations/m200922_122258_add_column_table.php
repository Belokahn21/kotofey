<?php

use yii\db\Migration;

class m200922_122258_add_column_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%vendor}}', 'how_send_order', $this->integer()->defaultValue(0)->notNull());
    }

    public function safeDown()
    {
        $this->dropColumn('{{%vendor}', 'how_send_order');
    }
}
