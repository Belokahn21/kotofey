<?php

use yii\db\Migration;

class m201022_035520_052_create_table_vendor_group extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%vendor_group}}', [
            'id' => $this->primaryKey(),
            'is_active' => $this->tinyInteger(1)->defaultValue('1'),
            'sort' => $this->integer()->defaultValue('500'),
            'name' => $this->string()->notNull(),
            'slug' => $this->string()->notNull(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);

    }

    public function down()
    {
        $this->dropTable('{{%vendor_group}}');
    }
}
