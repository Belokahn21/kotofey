<?php

use yii\db\Migration;

/**
 * Class m200217_111724_rollback
 */
class m200217_111724_rollback extends Migration
{
	/**
	 * {@inheritdoc}
	 */
	public function safeUp()
	{
		$this->dropTable('{{%user_manager_score}}');
		$this->dropTable('{{%user_manager}}');
	}

	/**
	 * {@inheritdoc}
	 */
	public function safeDown()
	{
		echo "m200217_111724_rollback cannot be reverted.\n";

		return false;
	}

	/*
	// Use up()/down() to run migration code without a transaction.
	public function up()
	{

	}

	public function down()
	{
		echo "m200217_111724_rollback cannot be reverted.\n";

		return false;
	}
	*/
}
