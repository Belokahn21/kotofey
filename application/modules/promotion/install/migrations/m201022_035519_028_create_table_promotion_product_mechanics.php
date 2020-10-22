<?php

use yii\db\Migration;

class m201022_035519_028_create_table_promotion_product_mechanics extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%promotion_product_mechanics}}', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer()->notNull(),
            'promotion_mechanic_id' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);

    }

    public function down()
    {
        $this->dropTable('{{%promotion_product_mechanics}}');
    }
}
