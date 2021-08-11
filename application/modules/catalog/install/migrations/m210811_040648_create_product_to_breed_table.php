<?php

use yii\db\Migration;

class m210811_040648_create_product_to_breed_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%product_to_breed}}', [
            'id' => $this->primaryKey(),
            'breed_id' => $this->integer()->notNull(),
            'product_id' => $this->integer()->notNull(),
            'animal_id' => $this->integer()->notNull(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%product_to_breed}}');
    }
}
