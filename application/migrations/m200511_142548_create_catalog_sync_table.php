<?php

use yii\db\Migration;

class m200511_142548_create_catalog_sync_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%product_sync}}', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer()->notNull(),
            'last_run_at' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);

        // creates index for column `author_id`
        $this->createIndex(
            'idx-product_sync-product_id',
            'product_sync',
            'product_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-product_sync-product_id',
            'product_sync',
            'product_id',
            'product',
            'id',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropTable('{{%catalog_sync}}');
    }
}
