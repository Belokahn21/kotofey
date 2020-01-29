<?php

use yii\db\Migration;

class m200129_102533_modify_product_table extends Migration
{
	public function safeUp()
	{
		$this->addColumn('{{%product}}', 'discount_price', $this->integer()->null()->after('price'));
	}

	public function safeDown()
	{
		$this->dropColumn('{{%product}}', 'discount_price');
	}
}
