<?php

use yii\db\Migration;

class m210411_033748_create_add_fields extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%user_billing}}', 'client', $this->integer()->after('name'));
        $this->addColumn('{{%user_billing}}', 'index', $this->integer()->after('user_id'));
        $this->addColumn('{{%user_billing}}', 'region', $this->string(128)->after('index'));
        $this->addColumn('{{%user_billing}}', 'entrance', $this->string(128)->after('home'));
        $this->addColumn('{{%user_billing}}', 'floor_house', $this->string(128)->after('entrance'));

        $this->dropForeignKey('fk-user_billing-user_id', '{{%user_billing}}');
        $this->dropIndex('idx-user_billing-user_id', '{{%user_billing}}');


        $this->dropColumn('{{%user_billing}}', 'user_id');
        $this->addColumn('{{%user_billing}}', 'phone', $this->bigInteger()->after('id'));
    }

    public function safeDown()
    {
    }
}
