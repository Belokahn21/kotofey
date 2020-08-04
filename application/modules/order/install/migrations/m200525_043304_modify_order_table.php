<?php

use yii\db\Migration;

class m200525_043304_modify_order_table extends Migration
{
	public function safeUp()
	{
		$this->addColumn('orders', 'email', $this->string(255)->null()->after('phone'));

		$this->addColumn('orders', 'postalcode', $this->string(15)->null());
		$this->addColumn('orders', 'country', $this->string(100)->null());
		$this->addColumn('orders', 'region', $this->string(100)->null());
		$this->addColumn('orders', 'city', $this->string(100)->null());
		$this->addColumn('orders', 'street', $this->string(100)->null());
		$this->addColumn('orders', 'number_home', $this->string(10)->null());
		$this->addColumn('orders', 'number_appartament', $this->string(10)->null());
	}

	public function safeDown()
	{
		$this->dropColumn('orders', 'email');
	}
}
