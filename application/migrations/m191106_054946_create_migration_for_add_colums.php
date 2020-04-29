<?php

use yii\db\Migration;

/**
 * Class m191106_054946_create_migration_for_add_colums
 */
class m191106_054946_create_migration_for_add_colums extends Migration
{
	/**
	 * {@inheritdoc}
	 */
	public function safeUp()
	{
		$this->addColumn('{{%stocks}}', 'active', $this->boolean()->notNull()->defaultValue(true)->after('id'));
		$this->addColumn('{{%stocks}}', 'sort', $this->integer()->notNull()->defaultValue(500)->after('active'));
	}

	/**
	 * {@inheritdoc}
	 */
	public function safeDown()
	{
		$this->dropColumn('{{%stocks}}', 'active');
		$this->dropColumn('{{%stocks}}', 'sort');
		return false;
	}

	/*
	// Use up()/down() to run migration code without a transaction.
	public function up()
	{

	}

	public function down()
	{
		echo "m191106_054946_create_migration_for_add_colums cannot be reverted.\n";

		return false;
	}
	*/
}
