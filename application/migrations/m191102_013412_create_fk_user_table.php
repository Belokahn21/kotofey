<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%fk_user}}`.
 */
class m191102_013412_create_fk_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute('ALTER TABLE `user` ENGINE = InnoDB;');
        $this->execute('ALTER TABLE `user_billing` ENGINE = InnoDB;');
        $this->execute('ALTER TABLE `discount` ENGINE = InnoDB;');
        $this->createIndex('idx-user_discount-user_id', '{{%discount}}', 'user_id');
        $this->addForeignKey('fk-user_discount-user_id', '{{%discount}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE');
        $this->createIndex('idx-user_billing-user_id', '{{%user_billing}}', 'user_id');
        $this->addForeignKey('fk-user_billing-user_id', '{{%user_billing}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE');


        $this->execute('ALTER TABLE `orders` ENGINE = InnoDB;');
        $this->execute('ALTER TABLE `order_items` ENGINE = InnoDB;');
        $this->createIndex('idx-order_items-orders-user_id', '{{%order_items}}', 'orderId');
        $this->addForeignKey('fk-order_items-orders-user_id', '{{%order_items}}', 'orderId', '{{%orders}}', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('idx-user_billing-user_id','{{%user_billing}}');
        $this->dropForeignKey('fk-user_billing-user_id','{{%user}}');
    }
}
