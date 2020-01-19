<?php

use yii\db\Migration;

class m200118_104812_modify_geo_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%geo}}', 'time_zone_id', $this->string(255)->null()->after('type'));
    }

    public function safeDown()
    {
        $this->dropColumn('{{%geo}}', 'time_zone');
    }
}
