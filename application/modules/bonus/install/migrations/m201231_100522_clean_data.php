<?php

use yii\db\Migration;

class m201231_100522_clean_data extends Migration
{
    public function safeUp()
    {
        $this->truncateTable('{{%user_bonus}}');

        // code

        $users = \app\modules\user\models\entity\User::find()->all();

        foreach ($users as $user) {
            $obj = new \app\modules\bonus\models\entity\UserBonus();
            $obj->phone = $user->phone;
            $obj->count = 0;

            if (!$obj->validate() or !$obj->save()) return false;
        }

    }

    public function safeDown()
    {
    }
}
