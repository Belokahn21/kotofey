<?php

use yii\db\Migration;

class m191031_040055_create_table_user_billing extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user_billing}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'city' => $this->string(),
            'street' => $this->string(),
            'home' => $this->string(),
            'house' => $this->string(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);

    }

    public function down()
    {
        $this->dropTable('{{%user_billing}}');
    }
}
