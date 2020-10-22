<?php

use yii\db\Migration;

class m201022_035519_001_create_table_auth extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%auth}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'source' => $this->string()->notNull(),
            'source_id' => $this->string()->notNull(),
        ], $tableOptions);

        $this->createIndex('fk-auth-user_id-user-id', '{{%auth}}', 'user_id');
    }

    public function down()
    {
        $this->dropTable('{{%auth}}');
    }
}
