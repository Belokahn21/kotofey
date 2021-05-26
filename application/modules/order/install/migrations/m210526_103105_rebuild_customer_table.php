<?php

use yii\db\Migration;

/**
 * Class m210526_103105_rebuild_customer_table
 */
class m210526_103105_rebuild_customer_table extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->dropTable('{{%customer}}');

        $this->createTable('{{%customer}}', [
//            'id' => $this->primaryKey(),
            'phone' => $this->bigInteger(),
            'is_active' => $this->boolean()->defaultValue(true),
            'sort' => $this->integer()->defaultValue(500),
            'name' => $this->string(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);

        $this->createIndex('idx-customer_phone', 'customer', 'phone');
    }

    public function safeDown()
    {
    }
}
