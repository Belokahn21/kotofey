<?php

use yii\db\Migration;

class m200212_054805_modify_vendor_table extends Migration
{
	public function safeUp()
	{
		$this->addColumn('{{%vendor}}', 'delivery_days', $this->string()->after('address'));
		$this->addColumn('{{%vendor}}', 'email', $this->string()->after('delivery_days'));
		$this->addColumn('{{%vendor}}', 'phone', $this->string()->after('email'));
	}

	public function safeDown()
	{
		$this->dropColumn('{{%vendor}}', 'delivery_days');
		$this->dropColumn('{{%vendor}}', 'email');
		$this->dropColumn('{{%vendor}}', 'phone');
	}
}
