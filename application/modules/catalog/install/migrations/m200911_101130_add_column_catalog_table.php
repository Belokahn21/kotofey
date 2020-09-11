<?php

use yii\db\Migration;

class m200911_101130_add_column_catalog_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%product}}', 'status_id', 'integer default 1');
    }

    public function safeDown()
    {
        $this->dropColumn('{{%product}}', 'status_id');
    }
}
