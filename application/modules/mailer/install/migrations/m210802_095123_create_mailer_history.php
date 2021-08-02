<?php

use yii\db\Migration;

class m210802_095123_create_mailer_history extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';

        $this->createTable('{{%mail_history}}', [
            'id' => $this->primaryKey(),
            'mail_template_id' => $this->integer(),
            'email' => $this->string(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);
    }

    public function safeDown()
    {
    }
}
