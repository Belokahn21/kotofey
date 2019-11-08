<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%add_fields_informers_values}}`.
 */
class m191108_150837_create_add_fields_informers_values_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%informers_values}}', 'active', $this->boolean()->defaultValue(1)->notNull()->after('id'));
        $this->addColumn('{{%informers_values}}', 'sort', $this->integer()->defaultValue(500)->notNull()->after('active'));
        $this->addColumn('{{%informers_values}}', 'image', $this->string()->after('sort'));
        $this->addColumn('{{%informers_values}}', 'slug', $this->string()->after('image'));
        $this->addColumn('{{%informers_values}}', 'created_at', $this->integer()->after('value'));
        $this->addColumn('{{%informers_values}}', 'updated_at', $this->integer()->after('created_at'));

        $this->renameColumn('{{%informers_values}}', 'value', 'name');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%informers_values}}', 'active');
        $this->dropColumn('{{%informers_values}}', 'sort');
        $this->dropColumn('{{%informers_values}}', 'image');
        $this->dropColumn('{{%informers_values}}', 'slug');
        $this->dropColumn('{{%informers_values}}', 'created_at');
        $this->dropColumn('{{%informers_values}}', 'updated_at');

        $this->renameColumn('{{%informers_values}}', 'name', 'value');
    }
}
