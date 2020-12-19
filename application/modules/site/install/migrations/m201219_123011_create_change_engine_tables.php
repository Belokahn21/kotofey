<?php

use yii\db\Migration;

class m201219_123011_create_change_engine_tables extends Migration
{
    public function safeUp()
    {
        $this->execute('ALTER TABLE `auth` ENGINE = InnoDB;');
        $this->execute('ALTER TABLE `delivery` ENGINE = InnoDB;');
        $this->execute('ALTER TABLE `geo` ENGINE = InnoDB;');
        $this->execute('ALTER TABLE `geo_timezone` ENGINE = InnoDB;');
        $this->execute('ALTER TABLE `news` ENGINE = InnoDB;');
        $this->execute('ALTER TABLE `news_category` ENGINE = InnoDB;');
        $this->execute('ALTER TABLE `orders_billing` ENGINE = InnoDB;');
        $this->execute('ALTER TABLE `order_date` ENGINE = InnoDB;');
        $this->execute('ALTER TABLE `payment` ENGINE = InnoDB;');
        $this->execute('ALTER TABLE `product_market` ENGINE = InnoDB;');
        $this->execute('ALTER TABLE `product_order` ENGINE = InnoDB;');
        $this->execute('ALTER TABLE `product_reviews` ENGINE = InnoDB;');
        $this->execute('ALTER TABLE `providers` ENGINE = InnoDB;');
        $this->execute('ALTER TABLE `search_query` ENGINE = InnoDB;');
        $this->execute('ALTER TABLE `short_links` ENGINE = InnoDB;');
        $this->execute('ALTER TABLE `site_reviews` ENGINE = InnoDB;');
        $this->execute('ALTER TABLE `site_settings` ENGINE = InnoDB;');
        $this->execute('ALTER TABLE `site_type_settings` ENGINE = InnoDB;');
        $this->execute('ALTER TABLE `sliders` ENGINE = InnoDB;');
        $this->execute('ALTER TABLE `sliders_images` ENGINE = InnoDB;');
        $this->execute('ALTER TABLE `status_order` ENGINE = InnoDB;');
        $this->execute('ALTER TABLE `stocks` ENGINE = InnoDB;');
        $this->execute('ALTER TABLE `subscribes` ENGINE = InnoDB;');
        $this->execute('ALTER TABLE `support_category` ENGINE = InnoDB;');
        $this->execute('ALTER TABLE `support_message` ENGINE = InnoDB;');
        $this->execute('ALTER TABLE `support_status` ENGINE = InnoDB;');
        $this->execute('ALTER TABLE `support_ticket` ENGINE = InnoDB;');
        $this->execute('ALTER TABLE `todo_list` ENGINE = InnoDB;');
        $this->execute('ALTER TABLE `users_referal` ENGINE = InnoDB;');
        $this->execute('ALTER TABLE `user_sex` ENGINE = InnoDB;');
        $this->execute('ALTER TABLE `vacancy` ENGINE = InnoDB;');
        $this->execute('ALTER TABLE `vendor_group` ENGINE = InnoDB;');
    }

    public function safeDown()
    {
    }
}
