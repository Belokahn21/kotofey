<?php

use yii\db\Migration;

/**
 * Class m191223_101309_modify_billing_table
 */
class m191223_101309_modify_billing_table extends Migration
{
	/**
	 * {@inheritdoc}
	 */
	public function safeUp()
	{
		$this->addColumn('{{%user_billing}}', 'name', $this->string(255)->null()->after('id'));
		$this->addColumn('{{%user_billing}}', 'is_main', $this->boolean()->defaultValue(false)->after('name'));
	}

	/**
	 * {@inheritdoc}
	 */
	public function safeDown()
	{
		echo "m191223_101309_modify_billing_table cannot be reverted.\n";

		return false;
	}

	/*
	// Use up()/down() to run migration code without a transaction.
	public function up()
	{

	}

	public function down()
	{
		echo "m191223_101309_modify_billing_table cannot be reverted.\n";

		return false;
	}
	*/
}
