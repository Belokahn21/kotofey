<?php

use yii\db\Migration;

class m201022_035519_018_create_table_product_market extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%product_market}}', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer()->notNull(),
            'market_id' => $this->integer()->notNull(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);

        $this->createIndex('idx-product_market-product_id', '{{%product_market}}', 'product_id');
    }

    public function down()
    {
        $this->dropTable('{{%product_market}}');
    }
}
