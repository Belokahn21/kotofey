<?php

use yii\db\Migration;

class m191031_042232_create_table_user extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'auth_key' => $this->string(),
            'access_token' => $this->string(),
            'email' => $this->string(128),
            'phone' => $this->bigInteger()->notNull(),
            'password' => $this->string(256)->notNull(),
            'avatar' => $this->string(256),
            'vk_uid' => $this->bigInteger(25),
            'birthday' => $this->integer(),
            'sex' => $this->integer(),
            'first_name' => $this->string(128),
            'name' => $this->string(128),
            'last_name' => $this->string(128),
            'vk_link' => $this->string(256),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);

    }

    public function down()
    {
        $this->dropTable('{{%user}}');
    }
}
