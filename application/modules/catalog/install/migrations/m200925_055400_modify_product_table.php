<?php

use yii\db\Migration;

class m200925_055400_modify_product_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%product}}', 'barcode', $this->string(255)->null()->after('code')->comment('Штрих-код'));
    }

    public function safeDown()
    {
        $this->dropColumn('{{%product}}', 'barcode');
    }
}
