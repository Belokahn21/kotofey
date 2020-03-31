<?php

use yii\db\Migration;

class m200331_080246_create_modify_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%promo}}', 'is_active', $this->boolean()->defaultValue(1)->after('id'));
    }

    public function safeDown()
    {
        $this->dropColumn('{{%promo}}', 'is_active');
    }
}
