<?php

use yii\db\Migration;

class m210504_052430_add_columns_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%reviews}}', 'status_id', $this->integer()->defaultValue(0)->after('id'));
        $this->addColumn('{{%reviews}}', 'is_active', $this->boolean()->defaultValue(0)->after('status_id'));
    }

    public function safeDown()
    {
        $this->dropColumn('{{%reviews}}', 'status_id');
        $this->dropColumn('{{%reviews}}', 'is_active');
    }

}
