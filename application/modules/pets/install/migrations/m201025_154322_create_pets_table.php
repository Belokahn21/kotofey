<?php

use yii\db\Migration;

class m201025_154322_create_pets_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%pets}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'name' => $this->string(255)->notNull(),
            'birthday' => $this->string(255),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%pets}}');
    }
}
