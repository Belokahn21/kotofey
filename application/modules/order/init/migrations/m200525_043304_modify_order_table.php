<?php

use yii\db\Migration;

class m200525_043304_modify_order_table extends Migration
{
	public function safeUp()
	{
		$this->addColumn('orders', 'email', $this->string(255)->null()->after('phone'));
	}

	public function safeDown()
	{
		$this->dropColumn('orders', 'email');
	}
}
