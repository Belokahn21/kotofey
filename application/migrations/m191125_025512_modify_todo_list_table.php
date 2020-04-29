<?php

use yii\db\Migration;

/**
 * Class m191125_025512_modify_todo_list_table
 */
class m191125_025512_modify_todo_list_table extends Migration
{
	/**
	 * {@inheritdoc}
	 */
	public function safeUp()
	{
		$this->addColumn('{{%todo_list}}', 'user_id', $this->integer()->notNull()->defaultValue(0)->after('id'));
	}

	/**
	 * {@inheritdoc}
	 */
	public function safeDown()
	{
		$this->dropColumn('{{%todo_list}}', 'user_id');
	}

	/*
	// Use up()/down() to run migration code without a transaction.
	public function up()
	{

	}

	public function down()
	{
		echo "m191125_025512_modify_todo_list_table cannot be reverted.\n";

		return false;
	}
	*/
}
