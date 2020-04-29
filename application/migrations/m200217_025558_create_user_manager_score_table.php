<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_manager_score}}`.
 */
class m200217_025558_create_user_manager_score_table extends Migration
{
	/**
	 * {@inheritdoc}
	 */
	public function safeUp()
	{
		$this->createTable('{{%user_manager_score}}', [
			'id' => $this->primaryKey(),
			'user_id' => $this->integer(),
			'score' => $this->integer(),
			'created_at' => $this->integer(),
			'updated_at' => $this->integer(),
		]);
	}

	/**
	 * {@inheritdoc}
	 */
	public function safeDown()
	{
		$this->dropTable('{{%user_manager_score}}');
	}
}
