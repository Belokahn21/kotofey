<?php

use yii\db\Migration;

class m210910_063639_modify_mail_temolate_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%mail_templates}}', 'layout', $this->string()->after('event_id'));
        $this->addColumn('{{%mail_templates}}', 'template', $this->string()->after('event_id'));
    }

    public function safeDown()
    {
    }
}
