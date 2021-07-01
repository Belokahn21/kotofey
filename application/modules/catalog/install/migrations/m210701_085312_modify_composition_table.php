<?php

use yii\db\Migration;

class m210701_085312_modify_composition_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%composition}}', 'composition_type_id', $this->integer()->after('name'));

        $this->dropColumn('{{%composition_products}}', 'composition_type_id');
        $this->addColumn('{{%composition_products}}', 'metric_id', $this->string()->after('id'));
    }

    public function safeDown()
    {
        $this->dropColumn('{{%composition}}', 'composition_type_id');
    }
}
