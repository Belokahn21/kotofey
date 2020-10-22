<?php

use yii\db\Migration;

class m201022_035519_021_create_table_product_properties_values extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%product_properties_values}}', [
            'id' => $this->primaryKey(),
            'property_id' => $this->integer()->notNull(),
            'product_id' => $this->integer()->notNull(),
            'value' => $this->text()->notNull(),
        ], $tableOptions);

    }

    public function down()
    {
        $this->dropTable('{{%product_properties_values}}');
    }
}
