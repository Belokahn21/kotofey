<?php

use yii\db\Migration;

class m201027_145935_modify_props_values_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%informers_values}}', 'media_id', $this->integer()->after('image'));
    }

    public function safeDown()
    {
        $this->dropColumn('{{%informers_values}}', 'media_id');
    }

}
