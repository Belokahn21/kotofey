<?php

use yii\db\Migration;

class m201005_042158_create_promotion_product_mechanics_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%promotion_product_mechanics}}', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer()->notNull(),
            'promotion_mechanic_id' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%promotion_product_mechanics}}');
    }
}
