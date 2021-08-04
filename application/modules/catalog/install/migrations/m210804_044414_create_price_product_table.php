<?php

use yii\db\Migration;

class m210804_044414_create_price_product_table extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%price_product}}', [
            'id' => $this->primaryKey(),
            'price_id' => $this->integer(),
            'product_id' => $this->integer(),
            'value' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);
    }

    public function safeDown()
    {
        $this->dropTable('{{%price_product}}');
    }
}
