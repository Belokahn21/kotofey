<?php

use yii\db\Migration;

class m210109_133431_add_related_table extends Migration
{
    public function safeUp()
    {
        $this->createIndex('idx-promotion_product_mechanics-promotion-user_id', '{{%promotion_product_mechanics}}', 'promotion_id');
        $this->addForeignKey('fk-promotion_product_mechanics-promotion-user_id', '{{%promotion_product_mechanics}}', 'promotion_id', '{{%promotion}}', 'id', 'CASCADE', 'CASCADE');

    }

    public function safeDown()
    {
    }

}
