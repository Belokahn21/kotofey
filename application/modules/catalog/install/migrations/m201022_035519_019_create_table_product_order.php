<?php

use yii\db\Migration;

class m201022_035519_019_create_table_product_order extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%product_order}}', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer()->notNull(),
            'start' => $this->integer()->notNull(),
            'end' => $this->integer()->notNull(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);

        $this->createIndex('product_id', '{{%product_order}}', 'product_id', true);
    }

    public function down()
    {
        $this->dropTable('{{%product_order}}');
    }
}
