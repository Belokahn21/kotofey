<?php

use yii\db\Migration;

class m200124_042222_modify_order_table extends Migration
{
	public function safeUp()
	{
		$this->addColumn('{{%orders}}', 'is_cancel', $this->boolean()->defaultValue(0)->after('is_paid'));
	}

	public function safeDown()
	{
		echo "m200124_042222_modify_order_table cannot be reverted.\n";

		return false;
	}
}
