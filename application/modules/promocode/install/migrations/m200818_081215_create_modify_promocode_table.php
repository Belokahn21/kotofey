<?php

use yii\db\Migration;

class m200818_081215_create_modify_promocode_table extends Migration
{
	public function safeUp()
	{
		$this->addColumn('{{%promocode}}', 'infinity', $this->boolean()->defaultValue(0)->notNull()->after('discount'));
	}

	public function safeDown()
	{
		$this->dropColumn('{{%promocode}}', 'infinity');
	}
}
