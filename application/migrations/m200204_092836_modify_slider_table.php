<?php

use yii\db\Migration;

class m200204_092836_modify_slider_table extends Migration
{
	public function safeUp()
	{
		$this->addColumn('{{%sliders_images}}', 'end_at', $this->integer()->after('link'));
		$this->addColumn('{{%sliders_images}}', 'start_at', $this->integer()->after('link'));
	}

	public function safeDown()
	{
		$this->dropColumn('{{%sliders_images}}', 'start_at');
		$this->dropColumn('{{%sliders_images}}', 'end_at');
	}
}
