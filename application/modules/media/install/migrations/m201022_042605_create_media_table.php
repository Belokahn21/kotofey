<?php

use yii\db\Migration;

class m201022_042605_create_media_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%media}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->comment('media file name')->notNull(),
            'path' => $this->string(255)->comment('full path media'),
            'location' => $this->string(255)->comment('cdn/server')->notNull(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%media}}');
    }
}
