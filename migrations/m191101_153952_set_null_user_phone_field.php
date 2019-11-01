<?php

use yii\db\Migration;

/**
 * Class m191101_153952_set_null_user_phone_field
 */
class m191101_153952_set_null_user_phone_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->alterColumn('{{%user}}', 'phone', $this->bigInteger()->null()->defaultValue(null));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191101_153952_set_null_user_phone_field cannot be reverted.\n";
        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191101_153952_set_null_user_phone_field cannot be reverted.\n";

        return false;
    }
    */
}
