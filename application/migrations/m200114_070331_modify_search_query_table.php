<?php

use yii\db\Migration;

/**
 * Class m200114_070331_modify_search_query_table
 */
class m200114_070331_modify_search_query_table extends Migration
{
	/**
	 * {@inheritdoc}
	 */
	public function safeUp()
	{
		$this->addColumn('{{%search_query}}', 'count_find', $this->integer()->null());
	}

	/**
	 * {@inheritdoc}
	 */
	public function safeDown()
	{
		echo "m200114_070331_modify_search_query_table cannot be reverted.\n";

		return false;
	}

	/*
	// Use up()/down() to run migration code without a transaction.
	public function up()
	{

	}

	public function down()
	{
		echo "m200114_070331_modify_search_query_table cannot be reverted.\n";

		return false;
	}
	*/
}
