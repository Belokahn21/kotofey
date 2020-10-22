<?php

namespace app\commands;

use app\modules\catalog\models\entity\Product;
use app\modules\catalog\models\entity\ProductPropertiesValues;
use app\modules\vendors\models\entity\Vendor;
use yii\console\Controller;

class ConsoleController extends Controller
{
    public function actionRun()
    {
        \Yii::$app->db->createCommand('truncate table `migration`')->execute();
        \Yii::$app->db->createCommand("-- --------------------------------------------------------
-- Хост:                         127.0.0.1
-- Версия сервера:               5.7.29-log - MySQL Community Server (GPL)
-- Операционная система:         Win64
-- HeidiSQL Версия:              11.0.0.5919
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Дамп данных таблицы kotofey_store.migration: ~59 rows (приблизительно)
/*!40000 ALTER TABLE `migration` DISABLE KEYS */;
INSERT INTO `migration` (`version`, `apply_time`) VALUES
	('m000000_000000_base', 1603378544),
	('m200929_092859_create_logger_table', 1603378548),
	('m200930_092859_modify_logger_table', 1603378549),
	('m200930_150000_modify_logger_table', 1603378549),
	('m201001_050221_modify_logger_table', 1603378549),
	('m201021_163727_create_cdek_geo_table', 1603378550),
	('m201022_035519_001_create_table_auth', 1603378544),
	('m201022_035519_002_create_table_auth_rule', 1603378544),
	('m201022_035519_003_create_table_delivery', 1603378546),
	('m201022_035519_004_create_table_geo', 1603378546),
	('m201022_035519_005_create_table_geo_timezone', 1603378546),
	('m201022_035519_006_create_table_informers', 1603378547),
	('m201022_035519_007_create_table_informers_values', 1603378547),
	('m201022_035519_009_create_table_news', 1603378550),
	('m201022_035519_010_create_table_news_category', 1603378550),
	('m201022_035519_011_create_table_order_date', 1603378546),
	('m201022_035519_012_create_table_orders', 1603378546),
	('m201022_035519_013_create_table_orders_billing', 1603378546),
	('m201022_035519_014_create_table_orders_items', 1603378546),
	('m201022_035519_015_create_table_payment', 1603378547),
	('m201022_035519_016_create_table_product', 1603378547),
	('m201022_035519_017_create_table_product_category', 1603378547),
	('m201022_035519_018_create_table_product_market', 1603378547),
	('m201022_035519_019_create_table_product_order', 1603378547),
	('m201022_035519_020_create_table_product_properties', 1603378547),
	('m201022_035519_021_create_table_product_properties_values', 1603378547),
	('m201022_035519_022_create_table_product_reviews', 1603378548),
	('m201022_035519_023_create_table_product_sync', 1603378548),
	('m201022_035519_024_create_table_promocode', 1603378547),
	('m201022_035519_025_create_table_promocode_user', 1603378547),
	('m201022_035519_026_create_table_promotion', 1603378549),
	('m201022_035519_027_create_table_promotion_mechanics', 1603378549),
	('m201022_035519_028_create_table_promotion_product_mechanics', 1603378549),
	('m201022_035519_035_create_table_sliders', 1603378551),
	('m201022_035519_036_create_table_sliders_images', 1603378551),
	('m201022_035519_037_create_table_status_order', 1603378546),
	('m201022_035519_038_create_table_stocks', 1603378551),
	('m201022_035519_039_create_table_subscribes', 1603378552),
	('m201022_035520_040_create_table_support_category', 1603378550),
	('m201022_035520_041_create_table_support_message', 1603378550),
	('m201022_035520_042_create_table_support_status', 1603378550),
	('m201022_035520_043_create_table_support_ticket', 1603378550),
	('m201022_035520_044_create_table_todo_list', 1603378551),
	('m201022_035520_045_create_table_user', 1603378544),
	('m201022_035520_046_create_table_user_billing', 1603378544),
	('m201022_035520_047_create_table_user_reset_password', 1603378544),
	('m201022_035520_048_create_table_user_sex', 1603378544),
	('m201022_035520_049_create_table_users_referal', 1603378545),
	('m201022_035520_050_create_table_vacancy', 1603378551),
	('m201022_035520_051_create_table_vendor', 1603378548),
	('m201022_035520_052_create_table_vendor_group', 1603378548),
	('m201022_035520_053_create_table_vendor_manager', 1603378548),
	('m201022_035520_054_create_table_auth_item', 1603378545),
	('m201022_035520_055_create_table_auth_item_child', 1603378545),
	('m201022_035520_056_create_table_discount', 1603378552),
	('m201022_035520_057_create_table_auth_assignment', 1603378545),
	('m201022_052722_031_create_table_short_links', 1603378552);
/*!40000 ALTER TABLE `migration` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
")->execute();



//        $products = Product::find()->where(['vendor_id' => Vendor::VENDOR_ID_FORZA])->all();
//        foreach ($products as $product) {
//            $product->scenario = Product::SCENARIO_UPDATE_PRODUCT;
//
//            $product->discount_price = null;
//
//            if ($product->validate()) {
//                if ($product->update()) {
//                    echo $product->code . "=" . $product->name;
//                    echo PHP_EOL;
//                }
//            }
//        }
    }

    public function actionClearCache()
    {
        \Yii::$app->cache->flush();
    }
}
