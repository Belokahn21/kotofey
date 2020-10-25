<?php

use yii\db\Migration;

class m201025_083935_modify_cdek_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%cdek_geo}}', 'postcode', $this->text()->after('city_id')->after('city_id'));
    }

    public function safeDown()
    {
        $this->dropColumn('{{%cdek_geo}}', 'postcode');
    }

}
