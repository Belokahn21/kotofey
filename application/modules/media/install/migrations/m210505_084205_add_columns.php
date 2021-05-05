<?php

use yii\db\Migration;

class m210505_084205_add_columns extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%media_to_entity}}', 'owner_id', $this->integer()->after('owner_object'));
    }

    public function safeDown()
    {
        $this->dropColumn('{{%media_to_entity}}', 'owner_id');
    }
}
