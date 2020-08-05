<?php

use yii\db\Migration;

class m200721_083422_modify_order_table extends Migration
{
	public function safeUp()
	{
		$this->addColumn('{{%orders}}', 'ip', $this->string(255)->after('comment')->notNull());
	}

	public function safeDown()
	{
		$this->dropColumn('{{%orders}}', 'ip');
	}
}
