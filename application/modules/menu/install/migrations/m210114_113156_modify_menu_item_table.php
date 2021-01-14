<?php

use yii\db\Migration;

class m210114_113156_modify_menu_item_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%menu_item}}', 'link', $this->string()->notNull()->after('name'));
    }

    public function safeDown()
    {
    }
}
