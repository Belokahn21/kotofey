<?php

use yii\db\Migration;

class m210715_032328_modify_catalog_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%product}}', 'updated_user_id', $this->integer()->defaultValue(0)->after('id'));
        $this->addColumn('{{%product}}', 'created_user_id', $this->integer()->defaultValue(0)->after('id'));
    }

    public function safeDown()
    {
    }
}
