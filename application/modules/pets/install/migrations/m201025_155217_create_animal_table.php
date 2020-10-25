<?php

use yii\db\Migration;

class m201025_155217_create_animal_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%animal}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%animal}}');
    }
}
