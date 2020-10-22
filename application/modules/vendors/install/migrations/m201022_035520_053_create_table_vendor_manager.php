<?php

use yii\db\Migration;

class m201022_035520_053_create_table_vendor_manager extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%vendor_manager}}', [
            'id' => $this->primaryKey(),
            'fio' => $this->string(),
            'vendor_id' => $this->integer(),
            'phone' => $this->bigInteger(),
            'email' => $this->string(),
            'welcome_message' => $this->string(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);

        $this->createIndex('idx-vendor-vendor_id', '{{%vendor_manager}}', 'vendor_id');
        $this->addForeignKey('fk-vendor-vendor_id', '{{%vendor_manager}}', 'vendor_id', '{{%vendor}}', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropTable('{{%vendor_manager}}');
    }
}
