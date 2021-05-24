<?php

use yii\db\Migration;

class m210524_072542_create_customer_table extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%customer}}', [
            'id' => $this->primaryKey(),
            'is_active' => $this->boolean()->defaultValue(true),
            'sort' => $this->integer()->defaultValue(500),
            'phone' => $this->bigInteger(),
            'name' => $this->string(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);


        $this->createTable('{{%customer_properties}}', [
            'id' => $this->primaryKey(),
            'is_active' => $this->boolean()->defaultValue(true),
            'sort' => $this->integer()->defaultValue(500),
            'name' => $this->string(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);

        $this->createTable('{{%customer_properties_values}}', [
            'id' => $this->primaryKey(),
            'customer_id' => $this->integer()->notNull(),
            'property_id' => $this->integer()->notNull(),
            'value' => $this->string(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);
    }

    public function safeDown()
    {
        $this->dropTable('{{%customer}}');
    }
}
