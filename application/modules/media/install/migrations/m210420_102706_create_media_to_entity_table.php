<?php

use yii\db\Migration;

class m210420_102706_create_media_to_entity_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%media_to_entity}}', [
            'id' => $this->primaryKey(),
            'media_id' => $this->integer(),
            'owner_object' => $this->string(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%media_to_entity}}');
    }
}
