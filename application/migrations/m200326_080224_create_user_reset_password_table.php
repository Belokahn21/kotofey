<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_reset_password}}`.
 */
class m200326_080224_create_user_reset_password_table extends Migration
{
	/**
	 * {@inheritdoc}
	 */
	public function safeUp()
	{
		$this->createTable('{{%user_reset_password}}', [
			'id' => $this->primaryKey(),
			'user_id' => $this->integer()->unique()->notNull(),
			'key' => $this->string(255)->unique()->notNull(),
			'created_at' => $this->integer(),
			'updated_at' => $this->integer(),
		]);
	}

	/**
	 * {@inheritdoc}
	 */
	public function safeDown()
	{
		$this->dropTable('{{%user_reset_password}}');
	}
}
