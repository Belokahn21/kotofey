<?php

use yii\db\Migration;

class m201005_021332_create_promotion_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%promotion}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
            'is_active' => $this->boolean()->defaultValue(1),
            'start_at' => $this->integer(),
            'end_at' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%promotion}}');
    }
}
