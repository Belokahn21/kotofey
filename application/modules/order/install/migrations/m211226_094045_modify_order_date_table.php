<?php

use app\modules\order\models\entity\OrderDate;
use app\modules\site\models\tools\Debug;
use yii\db\Migration;

class m211226_094045_modify_order_date_table extends Migration
{
    public function safeUp()
    {
        foreach (OrderDate::find()->all() as $item) {
            $item->date = date('Y-m-d', strtotime($item->date));

            if (!$item->validate() || !$item->update()) {
                return false;
            }
        }

        Yii::$app->db->createCommand('ALTER TABLE `order_date` CHANGE COLUMN `date` `date` DATE NOT NULL AFTER `order_id`;')->execute();
    }

    public function safeDown()
    {

    }
}
