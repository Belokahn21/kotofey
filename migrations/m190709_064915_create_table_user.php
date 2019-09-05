<?php

use yii\db\Migration;

class m190709_064915_create_table_user extends Migration
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
            'email' => $this->string(),
            'phone' => $this->bigInteger(),
            'password' => $this->string()->notNull(),
            'avatar' => $this->string(),
            'vk_uid' => $this->bigInteger(),
            'birthday' => $this->integer(),
            'sex' => $this->integer(),
            'first_name' => $this->string(),
            'name' => $this->string(),
            'last_name' => $this->string(),
            'vk_link' => $this->string(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);

    }

    public function down()
    {
        $this->dropTable('{{%user}}');
    }
}
