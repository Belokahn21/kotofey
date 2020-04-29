<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%geo_timezone}}`.
 */
class m200118_110204_create_geo_timezone_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%geo_timezone}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
            'value' => $this->string(255)->notNull(),
            'sort' => $this->integer()->defaultValue(500),
            'is_active' => $this->boolean()->defaultValue(true),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%geo_timezone}}');
    }
}
