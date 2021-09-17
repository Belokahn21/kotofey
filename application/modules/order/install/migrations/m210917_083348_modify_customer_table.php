<?php

use yii\db\Migration;

/**
 * Class m210917_083348_modify_customer_table
 */
class m210917_083348_modify_customer_table extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%customer_status}}', [
            'id' => $this->primaryKey(),
            'is_active' => $this->boolean()->defaultValue(true),
            'sort' => $this->integer()->defaultValue(500),
            'name' => $this->string(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);


        $this->addColumn('{{%customer}}', 'status_id', $this->integer());
    }

    public function safeDown()
    {
        echo "m210917_083348_modify_customer_table cannot be reverted.\n";

        return false;
    }
}
