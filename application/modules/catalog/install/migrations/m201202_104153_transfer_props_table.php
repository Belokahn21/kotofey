<?php

use yii\db\Migration;

class m201202_104153_transfer_props_table extends Migration
{
    public function safeUp()
    {
        $this->renameTable('{{%informers}}', '{{%save_informers}}');
        $this->renameTable('{{%informers_values}}', '{{%save_informers_values}}');
        $this->renameTable('{{%product_properties}}', '{{%save_product_properties}}');
        $this->renameTable('{{%product_properties_values}}', '{{%save_product_properties_values}}');


        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }


        $this->createTable('{{%properties}}', [
            'id' => $this->primaryKey(),
            'is_active' => $this->boolean()->defaultValue(1)->notNull(),
            'is_multiple' => $this->boolean()->defaultValue(0)->notNull(),
            'is_offer_catalog' => $this->boolean()->defaultValue(0)->notNull(),
            'is_show_site' => $this->boolean()->defaultValue(1)->notNull(),
            'name' => $this->string(128)->notNull(),
            'sort' => $this->integer()->defaultValue(500)->notNull(),
            'type' => $this->integer()->defaultValue(0),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);


        $this->createTable('{{%properties_variants}}', [
            'id' => $this->primaryKey(),
            'property_id' => $this->integer()->notNull(),
            'is_active' => $this->boolean()->defaultValue(1)->notNull(),
            'media_id' => $this->integer(),
            'link' => $this->text(),
            'name' => $this->string(128)->notNull(),
            'sort' => $this->integer()->defaultValue(500)->notNull(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);


        $this->createTable('{{%properties_product_values}}', [
            'id' => $this->primaryKey(),
            'property_id' => $this->integer()->notNull(),
            'product_id' => $this->integer()->notNull(),
            'value' => $this->string(255)->notNull(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);

        $this->createIndex(
            'idx-properties_variants-property_id',
            'properties_variants',
            'property_id'
        );

        $this->addForeignKey(
            'fk-properties_variants-property_id',
            'properties_variants',
            'property_id',
            'properties',
            'id',
            'CASCADE',
            'CASCADE'
        );

//        $this->createIndex(
//            'idx-properties_product_values-product_id',
//            'properties_product_values',
//            'product_id'
//        );
//
//        $this->addForeignKey(
//            'fk-properties_product_values-product_id',
//            'properties_product_values',
//            'product_id',
//            'offers',
//            'id',
//            'CASCADE',
//            'CASCADE'
//        );
    }

    public function safeDown()
    {
    }
}
