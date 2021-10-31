<?php

use yii\db\Migration;

class m211031_114830_create_tables extends Migration
{
    public function safeUp()
    {
        $this->dropForeignKey('fk-marketplace_product-product_id', 'marketplace_product');
        $this->execute('DROP TABLE IF EXISTS marketplace;');
        $this->execute('DROP TABLE IF EXISTS marketplace_product;');

        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }


        $this->createTable('{{%marketplace}}', [
            'id' => $this->primaryKey(),
            'is_active' => $this->boolean()->defaultValue(1),
            'sort' => $this->integer()->defaultValue(500),
            'name' => $this->string()->notNull(),
            'slug' => $this->string()->notNull(),
            'type_export_id' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);

        $this->createTable('{{%marketplace_product}}', [
            'id' => $this->primaryKey(),
            'marketplace_id' => $this->integer()->notNull(),
            'product_id' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createIndex('idx-marketplace_product-product-product_id', '{{%marketplace_product}}', 'product_id');
        $this->createIndex('idx-marketplace_product-marketplace-marketplace_id', '{{%marketplace_product}}', 'marketplace_id');
        $this->addForeignKey('fk-marketplace_product-product-product_id', '{{%marketplace_product}}', 'product_id', '{{%product}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk-marketplace_product-marketplace-marketplace_id', '{{%marketplace_product}}', 'marketplace_id', '{{%marketplace}}', 'id', 'CASCADE', 'CASCADE');
    }

    public function safeDown()
    {
    }
}
