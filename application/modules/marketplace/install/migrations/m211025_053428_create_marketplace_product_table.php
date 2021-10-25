<?php

use yii\db\Migration;

class m211025_053428_create_marketplace_product_table extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        $this->createTable('{{%marketplace_product}}', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer()->notNull(),
            'marketplace_id' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createIndex('idx-marketplace_product-product_id', '{{%marketplace_product}}', 'product_id');
        $this->addForeignKey('fk-marketplace_product-product_id', '{{%marketplace_product}}', 'product_id', '{{%product}}', 'id', 'CASCADE', 'CASCADE');
    }

    public function safeDown()
    {
        $this->dropTable('{{%marketplace_product}}');
    }
}
