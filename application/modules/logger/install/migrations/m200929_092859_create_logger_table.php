<?php

use yii\db\Migration;

class m200929_092859_create_logger_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%logger}}', [
            'id' => $this->primaryKey(),
            'message' => $this->text()->notNull(),
            'uniqCode' => $this->integer()->notNull(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer()
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%logger}}');
    }
}
