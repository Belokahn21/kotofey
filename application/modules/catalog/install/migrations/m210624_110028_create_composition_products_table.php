<?php

use yii\db\Migration;

class m210624_110028_create_composition_products_table extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%composition_products}}', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer()->notNull(),
            'composition_id' => $this->integer()->notNull(),
            'composition_type_id' => $this->integer()->notNull(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);
    }

    public function safeDown()
    {
        $this->dropTable('{{%composition_products}}');
    }
}
