<?php

use yii\db\Migration;

class m200923_031831_create_vendor_manager_table extends Migration
{
    public function safeUp()
    {
        $this->execute('ALTER TABLE `vendor` ENGINE = InnoDB;');

        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

        $this->createTable('{{%vendor_manager}}', [
            'id' => $this->primaryKey(),
            'fio' => $this->string(255),
            'vendor_id' => $this->integer(),
            'phone' => $this->bigInteger(),
            'email' => $this->string(255),
            'welcome_message' => $this->string(255),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);

        $this->createIndex(
            'idx-vendor-vendor_id',
            'vendor_manager',
            'vendor_id'
        );

        $this->addForeignKey(
            'fk-vendor-vendor_id',
            'vendor_manager',
            'vendor_id',
            'vendor',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropTable('{{%vendor_manager}}');

        $this->dropForeignKey(
            'fk-vendor-vendor_id',
            'vednor_manager'
        );

        $this->dropIndex(
            'idx-vendor-vendor_id',
            'vednor_manager'
        );
    }
}
