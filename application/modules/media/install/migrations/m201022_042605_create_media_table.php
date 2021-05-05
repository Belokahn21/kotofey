<?php

use yii\db\Migration;

class m201022_042605_create_media_table extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%media}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->comment('media file name')->notNull(),
            'path' => $this->string(255)->comment('full path media'),
            'location' => $this->string(255)->comment('cdn/server')->notNull(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);
    }

    public function safeDown()
    {
        $this->dropTable('{{%media}}');
    }
}
