<?php

use yii\db\Migration;

class m210805_025814_create_breed_table extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%breed}}', [
            'id' => $this->primaryKey(),
            'is_active' => $this->boolean()->defaultValue(1),
            'name' => $this->string()->notNull(),
            'sort' => $this->integer(),
            'animal_id' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);
    }

    public function safeDown()
    {
        $this->dropTable('{{%breed}}');
    }
}
