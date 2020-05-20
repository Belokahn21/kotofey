<?php

use yii\db\Migration;

class m200520_065918_create_modify_order_table extends Migration
{
	public function safeUp()
	{
		$this->addColumn('orders', 'phone', $this->bigInteger()->null()->after('id'));
	}

	public function safeDown()
	{
	}
}
