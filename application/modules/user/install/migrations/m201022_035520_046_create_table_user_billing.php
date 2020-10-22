<?php

use yii\db\Migration;

class m201022_035520_046_create_table_user_billing extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user_billing}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'is_main' => $this->tinyInteger(1)->defaultValue('0'),
            'user_id' => $this->integer(),
            'city' => $this->string(),
            'street' => $this->string(),
            'home' => $this->string(),
            'house' => $this->string(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);

        $this->createIndex('idx-user_billing-user_id', '{{%user_billing}}', 'user_id');
        $this->addForeignKey('fk-user_billing-user_id', '{{%user_billing}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropTable('{{%user_billing}}');
    }
}
