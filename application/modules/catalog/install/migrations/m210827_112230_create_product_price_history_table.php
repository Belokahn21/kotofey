<?php

use yii\db\Migration;

class m210827_112230_create_product_price_history_table extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%product_price_history}}', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer()->notNull(),
            'value' => $this->integer()->notNull(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer()
        ], $tableOptions);


        $this->createIndex('idx-product_price_history-product-product_id', '{{%product_price_history}}', 'product_id');
        $this->addForeignKey('fk-product_price_history-product-product_id', '{{%product_price_history}}', 'product_id', '{{%product}}', 'id', 'CASCADE', 'CASCADE');

    }

    public function safeDown()
    {
        $this->dropTable('{{%product_price_history}}');
    }
}
