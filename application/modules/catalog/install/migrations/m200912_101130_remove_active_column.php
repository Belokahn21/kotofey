<?php

use yii\db\Migration;

class m200912_101130_remove_active_column extends Migration
{
    public function safeUp()
    {
        $this->dropColumn('{{%product}}', 'active');
    }

    public function safeDown()
    {
        $this->addColumn('{{%product}}', 'active', $this->boolean()->defaultValue(1)->after('id'));
    }
}
