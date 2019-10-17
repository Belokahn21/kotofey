<?php

use yii\db\Migration;


class m191015_170450_create_providers_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('providers', [
            'id' => $this->primaryKey(),
            'active' => $this->boolean(),
            'sort' => $this->integer(),
            'name' => $this->string(255),
            'slug' => $this->string(255),
            'description' => $this->text(),
            'notes' => $this->text(),
            'link' => $this->string(255),
            'image' => $this->string(255),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('providers');
    }
}
