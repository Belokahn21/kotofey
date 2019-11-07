<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%search_query}}`.
 */
class m191107_083924_create_search_query_table extends Migration
{
	/**
	 * {@inheritdoc}
	 */
	public function safeUp()
	{
		$this->createTable('{{%search_query}}', [
			'id' => $this->primaryKey(),
			'text' => $this->text()->notNull(),
			'user_id' => $this->integer()->null(),
			'created_at' => $this->integer(),
			'updated_at' => $this->integer(),
		]);
	}

	/**
	 * {@inheritdoc}
	 */
	public function safeDown()
	{
		$this->dropTable('{{%search_query}}');
	}
}
