<?php

use yii\db\Migration;

class m201022_035519_023_create_table_product_sync extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%product_sync}}', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer()->notNull(),
            'last_run_at' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);

        $this->createIndex('idx-product_sync-product_id', '{{%product_sync}}', 'product_id');
        $this->addForeignKey('fk-product_sync-product_id', '{{%product_sync}}', 'product_id', '{{%product}}', 'id', 'CASCADE', 'RESTRICT');
    }

    public function down()
    {
        $this->dropTable('{{%product_sync}}');
    }
}
