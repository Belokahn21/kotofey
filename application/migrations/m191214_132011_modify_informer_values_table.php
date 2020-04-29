<?php

use yii\db\Migration;

/**
 * Class m191214_132011_modify_informer_values_table
 */
class m191214_132011_modify_informer_values_table extends Migration
{
	/**
	 * {@inheritdoc}
	 */
	public function safeUp()
	{
		$this->addColumn('{{%informers_values}}', 'link', $this->text()->null()->after('name'));
	}

	/**
	 * {@inheritdoc}
	 */
	public function safeDown()
	{
		$this->dropColumn('{{%informers_values}}', 'link');
	}
}
