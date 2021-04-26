<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%mail_templates}}`.
 */
class m210426_104137_create_mail_templates_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
//        $this->createTable('{{%mail_templates}}', [
//            'id' => $this->primaryKey(),
//        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%mail_templates}}');
    }
}
