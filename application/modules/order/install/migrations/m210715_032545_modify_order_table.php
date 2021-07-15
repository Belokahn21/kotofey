<?php

use yii\db\Migration;

class m210715_032545_modify_order_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%order}}', 'updated_user_id', $this->integer()->defaultValue(0)->after('id'));
        $this->addColumn('{{%order}}', 'created_user_id', $this->integer()->defaultValue(0)->after('id'));
    }

    public function safeDown()
    {
    }

}
