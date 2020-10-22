<?php

use yii\db\Migration;

class m201022_035519_022_create_table_product_reviews extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%product_reviews}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'product_id' => $this->integer()->notNull(),
            'text' => $this->text(),
            'author' => $this->string()->notNull()->defaultValue('255'),
            'images' => $this->text(),
            'rate' => $this->integer()->notNull()->defaultValue('0'),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);

    }

    public function down()
    {
        $this->dropTable('{{%product_reviews}}');
    }
}
