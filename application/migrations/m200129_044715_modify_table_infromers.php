<?php

use yii\db\Migration;

class m200129_044715_modify_table_infromers extends Migration
{
	public function safeUp()
	{
		$this->addColumn('{{%informers}}', 'is_active', $this->boolean()->defaultValue(1)->after('sort'));
		$this->addColumn('{{%informers}}', 'is_show_filter', $this->boolean()->defaultValue(1)->after('is_active'));
	}

	public function safeDown()
	{
		$this->dropColumn('{{%informers}}', 'is_active');
		$this->dropColumn('{{%informers}}', 'is_show_filter');
	}
}
