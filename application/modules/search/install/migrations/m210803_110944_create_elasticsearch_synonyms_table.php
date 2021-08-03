<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%elasticsearch_synonyms}}`.
 */
class m210803_110944_create_elasticsearch_synonyms_table extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%elasticsearch_synonyms}}', [
            'id' => $this->primaryKey(),
            'is_active' => $this->boolean()->defaultValue(true),
            'name' => $this->string(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);
    }

    public function safeDown()
    {
        $this->dropTable('{{%elasticsearch_synonyms}}');
    }
}
