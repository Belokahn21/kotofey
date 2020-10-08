<?php

use yii\db\Migration;

/**
 * Class m200217_072309_modify_search_query_table
 */
class m200217_072309_modify_search_query_table extends Migration
{
	/**
	 * {@inheritdoc}
	 */
	public function safeUp()
	{
		$this->addColumn('{{%search_query}}', 'ip', $this->string()->after('count_find'));
	}

	/**
	 * {@inheritdoc}
	 */
	public function safeDown()
	{
		echo "m200217_072309_modify_search_query_table cannot be reverted.\n";

		return false;
	}

	/*
	// Use up()/down() to run migration code without a transaction.
	public function up()
	{

	}

	public function down()
	{
		echo "m200217_072309_modify_search_query_table cannot be reverted.\n";

		return false;
	}
	*/
}
