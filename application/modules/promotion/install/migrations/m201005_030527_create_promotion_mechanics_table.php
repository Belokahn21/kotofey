<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%promotion_mechanics}}`.
 */
class m201005_030527_create_promotion_mechanics_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%promotion_mechanics}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
            'type' => $this->string()->notNull(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%promotion_mechanics}}');
    }
}
