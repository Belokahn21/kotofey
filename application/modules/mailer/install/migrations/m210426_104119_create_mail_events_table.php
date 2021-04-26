<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%mail_events}}`.
 */
class m210426_104119_create_mail_events_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
//        $this->createTable('{{%mail_events}}', [
//            'id' => $this->primaryKey(),
//        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%mail_events}}');
    }
}
