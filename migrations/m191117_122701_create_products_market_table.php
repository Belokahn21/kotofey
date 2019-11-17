<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%products_market}}`.
 */
class m191117_122701_create_products_market_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%product_market}}', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer()->notNull(),
            'market_id' => $this->integer()->notNull(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer()
        ]);


        $this->execute('ALTER TABLE `product` ENGINE = InnoDB;');
        $this->createIndex('idx-product_market-product_id', '{{%product_market}}', 'product_id');
        $this->addForeignKey('fk-product_market-product_id', '{{%product_market}}', 'product_id', '{{%product}}', 'id', 'CASCADE', 'CASCADE');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%products_market}}');
    }
}
