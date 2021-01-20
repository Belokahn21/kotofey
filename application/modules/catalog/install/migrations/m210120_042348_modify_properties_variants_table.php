<?php

use yii\db\Migration;

class m210120_042348_modify_properties_variants_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%properties_variants}}', 'slug', $this->string()->after('name'));
        $this->addColumn('{{%properties_variants}}', 'text', $this->text()->after('slug'));
        $this->addColumn('{{%properties_variants}}', 'image', $this->string()->after('media_id'));
        $this->addColumn('{{%properties_variants}}', 'view', $this->string()->after('image'));
    }

    public function safeDown()
    {
    }
}
