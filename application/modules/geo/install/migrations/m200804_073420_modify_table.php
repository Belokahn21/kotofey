<?php

use yii\db\Migration;

class m200804_073420_modify_table extends Migration
{
	public function safeUp()
	{
		$this->addColumn('{{%geo}}', 'address', $this->string()->after('name')->null());
		$this->addColumn('{{%geo}}', 'start_at', $this->integer()->after('address')->null());
		$this->addColumn('{{%geo}}', 'end_at', $this->integer()->after('start_at')->null());
	}

	public function safeDown()
	{
		$this->dropColumn('{{%geo}}', 'address');
		$this->dropColumn('{{%geo}}', 'start_at');
		$this->dropColumn('{{%geo}}', 'end_at');
	}
}
