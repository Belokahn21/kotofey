<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%users_referal}}`.
 */
class m200124_093537_create_users_referal_table extends Migration
{
	/**
	 * {@inheritdoc}
	 */
	public function safeUp()
	{
		$this->createTable('{{%users_referal}}', [
			'id' => $this->primaryKey(),
			'is_active' => $this->boolean()->defaultValue(1),
			'user_id' => $this->integer()->notNull(),
			'key' => $this->string(255)->notNull()->unique(),
			'key_called' => $this->string(255)->null(),
			'has_rewarded' => $this->boolean()->defaultValue(0),
			'count_reward' => $this->integer()->defaultValue(0),
			'created_at' => $this->integer(),
			'updated_at' => $this->integer(),
		]);
	}

	/**
	 * {@inheritdoc}
	 */
	public function safeDown()
	{
		$this->dropTable('{{%users_referal}}');
	}
}
