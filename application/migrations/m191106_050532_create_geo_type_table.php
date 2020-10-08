<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%geo_type}}`.
 */
class m191106_050532_create_geo_type_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%geo_type}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
            'slug' => $this->string(255)->notNull(),
            'active' => $this->boolean()->defaultValue(true)->notNull(),
            'sort' => $this->integer()->defaultValue(500)->notNull(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%geo_type}}');
    }
}
