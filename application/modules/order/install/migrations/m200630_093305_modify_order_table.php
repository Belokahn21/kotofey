<?php

use yii\db\Migration;

class m200630_093305_modify_order_table extends Migration
{
	public function safeUp()
	{
		$this->dropColumn('{{%orders}}', 'is_bonus');
	}

	public function safeDown()
	{
	}
}
