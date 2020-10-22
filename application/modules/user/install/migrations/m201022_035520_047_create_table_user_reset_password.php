<?php

use yii\db\Migration;

class m201022_035520_047_create_table_user_reset_password extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user_reset_password}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'key' => $this->string()->notNull(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);

        $this->createIndex('key', '{{%user_reset_password}}', 'key', true);
        $this->createIndex('user_id', '{{%user_reset_password}}', 'user_id', true);
    }

    public function down()
    {
        $this->dropTable('{{%user_reset_password}}');
    }
}
