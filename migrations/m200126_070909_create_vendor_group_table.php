<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%vendor_group}}`.
 */
class m200126_070909_create_vendor_group_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%vendor_group}}', [
            'id' => $this->primaryKey(),
            'is_active' => $this->boolean()->defaultValue(1),
            'sort' => $this->integer()->defaultValue(500),
            'name' => $this->string(255)->notNull(),
            'slug' => $this->string(255)->notNull(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%vendor_group}}');
    }
}
