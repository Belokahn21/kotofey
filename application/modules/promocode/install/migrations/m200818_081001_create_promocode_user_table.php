<?php

use yii\db\Migration;

class m200818_081001_create_promocode_user_table extends Migration
{
	public function safeUp()
	{
		$this->createTable('{{%promocode_user}}', [
			'id' => $this->primaryKey(),
			'phone' => $this->string(255)->notNull(),
			'code' => $this->string(255)->notNull(),
			'created_at' => $this->integer(),
			'updated_at' => $this->integer(),
		]);
	}

	public function safeDown()
	{
		$this->dropTable('{{%promocode_user}}');
	}
}
