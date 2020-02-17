<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_manager}}`.
 */
class m200217_044544_create_user_manager_table extends Migration
{
	/**
	 * {@inheritdoc}
	 */
	public function safeUp()
	{
		$this->createTable('{{%user_manager}}', [
			'id' => $this->primaryKey(),
			'user_id' => $this->integer()->unique(),
			'manager_id' => $this->integer(),
			'created_at' => $this->integer(),
			'updated_at' => $this->integer(),
		]);
	}

	/**
	 * {@inheritdoc}
	 */
	public function safeDown()
	{
		$this->dropTable('{{%user_manager}}');
	}
}
