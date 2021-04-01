<?php

use yii\db\Migration;

class m210319_102252_create_acquiring_order_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%acquiring_order}}', [
            'id' => $this->primaryKey(),
            'order_id' => $this->integer()->notNull(),
            'identifier_id' => $this->string(255)->notNull()->comment('ID в системе банков'),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%acquiring_order}}');
    }
}
