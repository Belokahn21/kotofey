<?php

use yii\db\Migration;

class m210805_055514_modify_animal_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%animal}}', 'media_id', $this->integer()->after('icon'));
    }

    public function safeDown()
    {
    }

}
