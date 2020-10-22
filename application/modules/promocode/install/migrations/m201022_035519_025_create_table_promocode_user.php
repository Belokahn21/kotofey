<?php

use yii\db\Migration;

class m201022_035519_025_create_table_promocode_user extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%promocode_user}}', [
            'id' => $this->primaryKey(),
            'phone' => $this->string()->notNull(),
            'code' => $this->string()->notNull(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);

    }

    public function down()
    {
        $this->dropTable('{{%promocode_user}}');
    }
}
