-- MySQL dump 10.13  Distrib 5.6.39-83.1, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: cd91333_shop
-- ------------------------------------------------------
-- Server version	5.6.39-83.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `auth_assignment`
--

DROP TABLE IF EXISTS `auth_assignment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_assignment` (
  `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`item_name`,`user_id`),
  KEY `auth_assignment_user_id_idx` (`user_id`),
  CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_assignment`
--

LOCK TABLES `auth_assignment` WRITE;
/*!40000 ALTER TABLE `auth_assignment` DISABLE KEYS */;
INSERT INTO `auth_assignment` VALUES ('Developer','1',1549015321),('Support','1',1552546349),('viewProduct','1',1552546614);
/*!40000 ALTER TABLE `auth_assignment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auth_item`
--

DROP TABLE IF EXISTS `auth_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_item` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` smallint(6) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`),
  KEY `rule_name` (`rule_name`),
  KEY `idx-auth_item-type` (`type`),
  CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_item`
--

LOCK TABLES `auth_item` WRITE;
/*!40000 ALTER TABLE `auth_item` DISABLE KEYS */;
INSERT INTO `auth_item` VALUES ('Administrator',1,'Управление сайтом и всем содержимым',NULL,NULL,1548181899,1548181899),('Developer',1,'Создатель всего, что ты видишь',NULL,NULL,1548181923,1548181923),('Support',1,'Отдел поддержки',NULL,NULL,1551199426,1551199426),('viewProduct',2,'Просмотр товара',NULL,NULL,1552546595,1552546595);
/*!40000 ALTER TABLE `auth_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auth_item_child`
--

DROP TABLE IF EXISTS `auth_item_child`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_item_child` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`),
  CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_item_child`
--

LOCK TABLES `auth_item_child` WRITE;
/*!40000 ALTER TABLE `auth_item_child` DISABLE KEYS */;
/*!40000 ALTER TABLE `auth_item_child` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auth_rule`
--

DROP TABLE IF EXISTS `auth_rule`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_rule` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_rule`
--

LOCK TABLES `auth_rule` WRITE;
/*!40000 ALTER TABLE `auth_rule` DISABLE KEYS */;
/*!40000 ALTER TABLE `auth_rule` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) DEFAULT NULL,
  `seo_keywords` varchar(255) DEFAULT NULL,
  `seo_description` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `sort` int(11) DEFAULT NULL,
  `parent` int(11) DEFAULT NULL,
  `image` varchar(256) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category`
--

LOCK TABLES `category` WRITE;
/*!40000 ALTER TABLE `category` DISABLE KEYS */;
INSERT INTO `category` VALUES (1,'Кошельки','Кошельки, купить Кошельки,  купить Кошельки молодежную, приобрести Кошельки, Кошельки со скидкой, Кошельки модных брендов, Кошельки  кожаная,','Ширкоий выбор кошельков из натуральной кожи выполненных ручной работой. Представлены мужские и женские акссуары на любой случай жизни','koselki',500,NULL,NULL,1547748627,1551851670),(2,'Портмоне',NULL,NULL,'portmone',500,NULL,NULL,1547748796,1547748796),(3,'Обложки',NULL,NULL,'oblozki',500,NULL,NULL,1547749231,1547749231),(4,'Ремни',NULL,NULL,'remni',500,NULL,NULL,1547794740,1547794740),(5,'Картхолдеры',NULL,NULL,'kartholdery',500,NULL,NULL,1549431937,1549431937),(6,'Чехлы для модов',NULL,NULL,'cehly-dla-modov',500,NULL,NULL,1551116427,1551116427);
/*!40000 ALTER TABLE `category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `delivery`
--

DROP TABLE IF EXISTS `delivery`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `delivery` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `delivery`
--

LOCK TABLES `delivery` WRITE;
/*!40000 ALTER TABLE `delivery` DISABLE KEYS */;
INSERT INTO `delivery` VALUES (1,'Транспортная компания','Транспортная компания СДЭК, ПЭК, Энергия',1548309013,1548309013),(2,'Доставка по городу','Бесплатно',1549430791,1549430791);
/*!40000 ALTER TABLE `delivery` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `discount`
--

DROP TABLE IF EXISTS `discount`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `discount` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `count` float DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `discount`
--

LOCK TABLES `discount` WRITE;
/*!40000 ALTER TABLE `discount` DISABLE KEYS */;
INSERT INTO `discount` VALUES (1,1,6.25),(2,16,0),(3,17,1.25),(4,2,0),(5,3,0),(6,4,0),(7,5,0),(8,6,0),(9,10,1.25),(10,11,0);
/*!40000 ALTER TABLE `discount` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migration`
--

DROP TABLE IF EXISTS `migration`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migration`
--

LOCK TABLES `migration` WRITE;
/*!40000 ALTER TABLE `migration` DISABLE KEYS */;
INSERT INTO `migration` VALUES ('m000000_000000_base',1547665997),('m190116_191337_create_user_table',1547666558),('m190117_064607_create_product_table',1547708834),('m190117_153535_create_category_table',1547739473),('m190121_100627_create_city_table',1548066826),('m140506_102106_rbac_init',1548173136),('m170907_052038_rbac_add_index_on_auth_assignment_user_id',1548173136),('m190123_072639_create_orders_table',1548228476),('m190123_075754_create_delivery_table',1548307809),('m190123_075800_create_payment_table',1548307809),('m190124_052626_create_delivery_table',1548307894),('m190124_052644_create_payment_table',1548307894),('m190124_090159_create_order_items_table',1548320732),('m190124_124013_create_status_order_table',1548333668),('m190206_064559_create_site_reviews_table',1549437993),('m190211_111805_create_product_reviews_table',1549884122),('m190212_072624_create_discount_table',1549957805),('m190213_105112_create_support_status_table',1550057750),('m190213_105117_create_support_ticket_table',1550057750),('m190213_105122_create_support_category_table',1550057750),('m190225_185429_create_support_message_table',1551120985),('m190305_080938_create_user_billing_table',1551773780);
/*!40000 ALTER TABLE `migration` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_items`
--

DROP TABLE IF EXISTS `order_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `orderId` int(11) DEFAULT NULL,
  `productId` int(11) DEFAULT NULL,
  `count` int(11) DEFAULT NULL,
  `summ` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_items`
--

LOCK TABLES `order_items` WRITE;
/*!40000 ALTER TABLE `order_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `order_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` int(11) NOT NULL,
  `delivery` int(11) DEFAULT NULL,
  `payment` int(11) DEFAULT NULL,
  `paid` tinyint(1) NOT NULL,
  `status` int(11) NOT NULL,
  `comment` text,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pages`
--

DROP TABLE IF EXISTS `pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `sort` int(11) NOT NULL,
  `category` int(11) DEFAULT NULL,
  `preview` text NOT NULL,
  `preview_image` varchar(255) DEFAULT NULL,
  `detail` text NOT NULL,
  `detail_image` varchar(255) DEFAULT NULL,
  `seo_keywords` varchar(255) DEFAULT NULL,
  `seo_description` varchar(255) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pages`
--

LOCK TABLES `pages` WRITE;
/*!40000 ALTER TABLE `pages` DISABLE KEYS */;
INSERT INTO `pages` VALUES (1,'Кожа Crazy Horse','koza-crazy-horse',500,1,'','/web/upload/59b514174bffe4ae402b3d63aad79fe0.jpg','',NULL,'','',1552977870,1552977870),(2,'Кожа Краст','koza-krast',500,1,'','/web/upload/84b7cfcf24514195688ec44ae8244d4a.jpg','',NULL,'','',1552977882,1552977882);
/*!40000 ALTER TABLE `pages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pages_category`
--

DROP TABLE IF EXISTS `pages_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pages_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `sort` int(11) NOT NULL,
  `parent` int(11) NOT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pages_category`
--

LOCK TABLES `pages_category` WRITE;
/*!40000 ALTER TABLE `pages_category` DISABLE KEYS */;
INSERT INTO `pages_category` VALUES (1,'Виды кожи',500,0,0,0);
/*!40000 ALTER TABLE `pages_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payment`
--

DROP TABLE IF EXISTS `payment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payment`
--

LOCK TABLES `payment` WRITE;
/*!40000 ALTER TABLE `payment` DISABLE KEYS */;
INSERT INTO `payment` VALUES (1,'Оплата банковской картой','Оплата банковской картой',1548308936,1548308936),(2,'Оплата наличными','Только при доставке по городу',1551887846,1551887846);
/*!40000 ALTER TABLE `payment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product`
--

DROP TABLE IF EXISTS `product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `article` varchar(64) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` text,
  `seo_description` varchar(150) DEFAULT NULL,
  `seo_keywords` varchar(180) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `images` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `sort` int(11) DEFAULT '500',
  `category` int(11) DEFAULT '0',
  `price` int(11) DEFAULT NULL,
  `purchase` int(11) DEFAULT NULL,
  `count` int(11) DEFAULT NULL,
  `vitrine` tinyint(1) DEFAULT '0',
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product`
--

LOCK TABLES `product` WRITE;
/*!40000 ALTER TABLE `product` DISABLE KEYS */;
INSERT INTO `product` VALUES (2,'K4BEDM','Портмоне стандарт','Компактный и в то же время очень вместительный аксессуар.\r\nОтличное решение для документов, денег и банковских карт.\r\nВыполнен из натуральной кожи и полностью вручную!\r\nВозможно нанесение вашего эскиза/рисунка','','кошельки портмоне +из натуральной кожи, портмоне ручной работы +из натуральной кожи, купить мужское портмоне +из натуральной кожи, мужские портмоне +из натуральной кожи интернет, к','/web/upload/41a4288776149a5d75718fe389cb5767.jpg','[]','portmone-standart',500,2,3200,2500,1,1,1547794617,1552332811),(3,'LCEHUK','Обложка на удостоверение','Обложка на удостоверение с нанесением гравировки государственных структур.\r\nГравировка входит в стоимость изделия.\r\nИзготовлено из натуральной кожи, полностью вручную','','','/web/upload/6512bd43d9caa6e02c990b0a82652dca.jpg','[]','oblozka-na-udostoverenie',500,3,2200,1700,1,1,1547794700,1552287415),(4,'LWT6QY','Ремень','Ремень из натуральной кожи толщиной 4мм с латунной фурнитурой.\r\nБрутальный аксессуар для настоящего мужчины!\r\nШирина 40мм, длинна регулируется под клиента.\r\nВозможен выбор цвета кожи и материала фурнитуры.\r\nВыполнен из натуральной кожи и полностью вручную!\r\nВозможно нанесение вашего эскиза/рисунка','','купить ремень +из натуральной кожи, ремень +из натуральной кожи купить недорого, ремень кожаный мужской +из натуральной кожи купить, мужские ремни +из натуральной кожи +для джинс, ','/web/upload/a66163f225e1cafc40174b70755e66bc.jpg','[]','remen',500,4,2900,2300,1,1,1547794798,1552333039),(16,'WO4U4E','Большой тревел для пластиковых карт','Однозначно любимая модель нашей мастерской\r\nТакой Тревел без проблем вмещает в себя 6-12 пластиковых карт, хорошую сумму наличных и смартфон','','картхолдеры +для пластиковых карт купить, картхолдер кожаный мужской купить, купить картхолдер ручной работы','/web/upload/da7ef114e67931cac8e75bd849332928.jpg','[\"/web/upload/14bebc2468556bce3790516bb45567ab.jpg\",\"/web/upload/c6462a4293f46d1cd56a081b4942b554.jpg\",\"/web/upload/daf6cd0ac07ee969b377b4c58a9d6960.jpg\"]','bolsoj-trevel-dla-plastikovyh-kart',500,5,3700,2900,1,1,1551093317,1552542708),(5,'DSTBO4','Обложка для паспорта \"MADE IN SIBERIA\"','Отличный подарок и просто интересный аксессуар из натуральной кожи.\r\nЦена указана за готовое изделие с данной гравировкой\r\nВыполнен из натуральной кожи и полностью вручную!','','обложка для автодокументов и паспорта, обложка +на паспорт +на заказ, обложки на паспорт ручной работы, обложка для паспорта мужская','/web/upload/49c0c9381f2f513e497a50495da6c0f1.jpg',NULL,'oblozka-dla-pasporta-made-in-siberia',500,3,2200,1700,1,1,1548097193,1552333843),(6,'OVL4OX','Обложка для паспорта \"Перо\"','Отличный подарок и просто интересный аксессуар из натуральной кожи.\r\nЦена указана за готовое изделие с данной гравировкой\r\nВыполнен из натуральной кожи и полностью вручную!','','обложка на паспорт из натуральной, обложка на паспорт из натуральной кожи, обложка на паспорт своими руками, обложка для паспорта мужская, где купить обложку на паспорт, обложка на','/web/upload/653bccd16a7f5cd841b0072157c3c706.jpg','[]','oblozka-dla-pasporta-pero',500,3,2200,1700,1,1,1548097563,1552334515),(7,'9JVETE','Обложка для паспорта \"Стандарт\"','Стандартная обложка из натуральной кожи с логотипом нашей мастерской.\r\nВозможно изготовление с применением другого цвета кожи и нити.\r\nВыполнен из натуральной кожи и полностью вручную!\r\nВозможно нанесение вашего эскиза/рисунка','','','/web/upload/5281a5282378eee2b145fa07c86850ca.jpg','[]','oblozka-dla-pasporta-standart',500,3,1500,1200,1,1,1548097637,1552286966),(8,'T7LOX1','Обложка для паспорта с принтом','Отличный подарок и просто интересный аксессуар из натуральной кожи.\r\nЦена указана за готовое изделие с данной гравировкой\r\nВыполнен из натуральной кожи и полностью вручную!','','','/web/upload/e4b40f80fab6ad3d4071db1ca3f7f8d3.jpg','[]','oblozka-dla-pasporta-s-printom',500,3,2200,1700,1,1,1548097695,1552287523),(9,'87CA82','Обложка для паспорта \"Рожденный в СССР\"','Отличный подарок и просто интересный аксессуар из натуральной кожи.\r\nЦена указана за готовое изделие с данной гравировкой\r\nВыполнен из натуральной кожи и полностью вручную!','','кожаная обложка паспорт ссср','/web/upload/22fcf678a5b97b93492f83932c9f7f54.jpg',NULL,'oblozka-dla-pasporta-rozdennyj-v-sssr',500,3,2200,1700,1,1,1548097767,1552294133),(10,'SMRT9U','EDC органайзер','Органайзер для EDC (Every Day Carry - термин, означающий совокупность предметов, носимых с собой ежедневно) вещей\r\nВключает в себя отделы для - Швейцарского ножа, шариковой ручки, фонарика и паспорта/блокнота.\r\nВыполнен из натуральной кожи и полностью вручную!\r\nВозможно нанесение вашего эскиза/рисунка','','','/web/upload/e6e39c8eb3e626054324ad14d9bc295b.jpg',NULL,'edc-organajzer',500,NULL,2500,2000,1,1,1548098316,1552286966),(11,'DSGIB3','Чехол для механического мода с подвесом на ремень','Чехол из толстой натуральной кожи с клапаном на кобурой кнопке с подвесом на ремень. \r\nОтлично подойдет для защиты вашего девайся от сколов и потертостей.\r\nИзготовлен из натуральной кожи вручную.','Чехол из толстой натуральной кожи с клапаном на кобурой кнопке с подвесом на ремень. \r\nОтлично подойдет для защиты вашего девайся от сколов и потертос','чехол для мех мода из кожи, чехол мода, чехол для электронной сигареты','/web/upload/102b260421e20ae77242b1a19f77cbc5.jpg',NULL,'cehol-dla-mehaniceskogo-moda-s-podvesom-na-remen',500,6,2000,1600,1,1,1548098355,1552335289),(12,'Q9GU8R','Чехол для механического мода на кнопке','Отлично подойдет для защиты вашего девайся от сколов и потертостей.\r\nИзготовлен из натуральной кожи вручную.\r\nВозможно нанесение вашего эскиза/рисунка','Отлично подойдет для защиты вашего девайся от сколов и потертостей.\r\nИзготовлен из натуральной кожи вручную.\r\nВозможно нанесение вашего эскиза/рисунка','чехол для мех мода из кожи, чехол мода','/web/upload/44ed4f091335d83766e982fa7a9e7bb0.jpg','[]','cehol-dla-mehaniceskogo-moda-na-knopke',500,6,1700,1300,1,1,1548098491,1552287540),(13,'LUBO9G','Браслет для часов','Браслет ручной работы из натуральной кожи для ваших часов.\r\nЦвет кожи и нити обговаривается лично. \r\nЦена на каждый браслет обговаривается.','','','/web/upload/1d725e91b20154ca8b88556cf60a0016.jpg',NULL,'braslet-dla-casov',500,4,1700,1300,1,1,1548098710,1552287555),(14,'VSY2K9','Вертикальный картхолдер','Минималистичный картхолдер с одним отделом под карты.\r\nСделано в ручную из натуральной кожи!','','','/web/upload/2024ff360d041079b38c8aa51d8c01ea.jpg',NULL,'vertikalnyj-kartholder',500,5,500,450,1,1,1548098747,1549431958),(15,'OKY8BZ','Парные браслеты','Отличный подарок и просто интересный аксессуар из натуральной кожи.\r\nЦена указана за готовое изделие с данной гравировкой\r\nВыполнен из натуральной кожи и полностью вручную!','','','/web/upload/2ddb9fb8ffb0d513d0b4341e180dc5c2.jpg',NULL,'parnye-braslety',500,4,850,750,1,1,1549432035,1551116378),(17,'97UHT','Широкий Браслет с Кельскими узорами','Элегантный мужской браслет с нанесённым на него Кельскими узором. Украсит любую мужскую руку\r\nЦена указанна за широкий браслет из толстой кожи растительного дубления с данной гравировкой','','кельские узоры, мужские браслеты из натуральной кожи, мужские браслеты на руку','/web/upload/c4ca4238a0b923820dcc509a6f75849b.jpg','[\"/web/upload/c81e728d9d4c2f636f067f89cc14862c.jpg\",\"/web/upload/eccbc87e4b5ce2fe28308fd9f2a7baf3.jpg\"]','sirokij-braslet-s-kelskimi-uzorami',500,4,850,790,1,1,1551287446,1552335500),(18,'6ONRQ','Футляр для канцелярских предметов','Идея превратившаяся в целое творение имеет изысканный вид лёгких повреждений, выполненных нанесением красок. Художники использующие карандаши оценят эту работу','','','/web/upload/7d2017d06af8492c49fc1f482b498fb5.jpg','[\"/web/upload/b18cdf1fc56de383d7fb3f814b89ba11.jpg\",\"/web/upload/3918615f5a38a7bf6a35ebd3adac0f56.jpg\",\"/web/upload/bd94503ce2ec0f787352406d91c90ac9.jpg\",\"/web/upload/b61a11f936900a99ee81ac7ddc4fb5e7.jpg\"]','futlar-dla-kancelarskih-predmetov',500,NULL,1500,1200,1,1,1552559628,1552627603);
/*!40000 ALTER TABLE `product` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_properties`
--

DROP TABLE IF EXISTS `product_properties`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_properties` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_properties`
--

LOCK TABLES `product_properties` WRITE;
/*!40000 ALTER TABLE `product_properties` DISABLE KEYS */;
INSERT INTO `product_properties` VALUES (1,'Тип кожи','tip-kozi',1552467132,1552467132),(2,'Цвет ниток','cvet-nitok',1552467140,1552467140),(3,'Вес','ves',1552467147,1552467147),(4,'Бренд','brend',1552467260,1552467260);
/*!40000 ALTER TABLE `product_properties` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_properties_values`
--

DROP TABLE IF EXISTS `product_properties_values`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_properties_values` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `property_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=36 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_properties_values`
--

LOCK TABLES `product_properties_values` WRITE;
/*!40000 ALTER TABLE `product_properties_values` DISABLE KEYS */;
INSERT INTO `product_properties_values` VALUES (32,3,1,'150'),(31,2,1,'Чёрный'),(30,1,1,'Монтеро'),(33,4,1,'Ручная работа'),(34,3,18,'150'),(35,4,18,'Ручная работа');
/*!40000 ALTER TABLE `product_properties_values` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_reviews`
--

DROP TABLE IF EXISTS `product_reviews`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_reviews` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `product` int(11) NOT NULL,
  `text` text,
  `images` text,
  `paid` tinyint(1) NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_reviews`
--

LOCK TABLES `product_reviews` WRITE;
/*!40000 ALTER TABLE `product_reviews` DISABLE KEYS */;
/*!40000 ALTER TABLE `product_reviews` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `site_reviews`
--

DROP TABLE IF EXISTS `site_reviews`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `site_reviews` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `text` text,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `site_reviews`
--

LOCK TABLES `site_reviews` WRITE;
/*!40000 ALTER TABLE `site_reviews` DISABLE KEYS */;
/*!40000 ALTER TABLE `site_reviews` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `site_settings`
--

DROP TABLE IF EXISTS `site_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `site_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `site_settings`
--

LOCK TABLES `site_settings` WRITE;
/*!40000 ALTER TABLE `site_settings` DISABLE KEYS */;
INSERT INTO `site_settings` VALUES (1,'Наценка товаров','saleup','20');
/*!40000 ALTER TABLE `site_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `status_order`
--

DROP TABLE IF EXISTS `status_order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `status_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(256) NOT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `status_order`
--

LOCK TABLES `status_order` WRITE;
/*!40000 ALTER TABLE `status_order` DISABLE KEYS */;
INSERT INTO `status_order` VALUES (1,'Товар отправлен клиенту',0,0);
/*!40000 ALTER TABLE `status_order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `support_category`
--

DROP TABLE IF EXISTS `support_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `support_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `html` text,
  `description` text,
  `sort` int(11) DEFAULT '500',
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `support_category`
--

LOCK TABLES `support_category` WRITE;
/*!40000 ALTER TABLE `support_category` DISABLE KEYS */;
INSERT INTO `support_category` VALUES (1,'Технические вопросы','<i class=\"far fa-life-ring\"></i>',NULL,NULL,1550601152,1550601152),(2,'Финансовые вопросы','<i class=\"fas fa-hand-holding-usd\"></i>',NULL,NULL,1550601171,1550601171);
/*!40000 ALTER TABLE `support_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `support_message`
--

DROP TABLE IF EXISTS `support_message`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `support_message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ticket_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `text` text,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `support_message`
--

LOCK TABLES `support_message` WRITE;
/*!40000 ALTER TABLE `support_message` DISABLE KEYS */;
/*!40000 ALTER TABLE `support_message` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `support_status`
--

DROP TABLE IF EXISTS `support_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `support_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `sort` int(11) DEFAULT '500',
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `support_status`
--

LOCK TABLES `support_status` WRITE;
/*!40000 ALTER TABLE `support_status` DISABLE KEYS */;
/*!40000 ALTER TABLE `support_status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `support_ticket`
--

DROP TABLE IF EXISTS `support_ticket`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `support_ticket` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `status_id` int(11) DEFAULT NULL,
  `is_close` tinyint(1) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `text` text,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `support_ticket`
--

LOCK TABLES `support_ticket` WRITE;
/*!40000 ALTER TABLE `support_ticket` DISABLE KEYS */;
/*!40000 ALTER TABLE `support_ticket` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `todo_list`
--

DROP TABLE IF EXISTS `todo_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `todo_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(256) NOT NULL,
  `description` text,
  `close` tinyint(1) NOT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=32 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `todo_list`
--

LOCK TABLES `todo_list` WRITE;
/*!40000 ALTER TABLE `todo_list` DISABLE KEYS */;
INSERT INTO `todo_list` VALUES (31,'Попробовать сделать модель-генратор с phpmyadmin','',0,1552925849,1552925849),(20,'форма 404 для сообщения об ошибки','',0,1551341941,1552654329),(5,'Раздел сообщения','',0,1549047865,1552654326),(18,'прошерстить ключи и описания разделов и товаров','',0,1551341894,1552654328),(19,'интеграция с сервисами доставки','деловые линии, пэк и тд',0,1551341922,1552654328),(10,'Определение города доделать, список городов','',0,1549194565,1552654328),(21,'Роли пользователя','',0,1551342062,1552654329),(22,'Разрешения пользователя','',0,1551342075,1552654330),(24,'Всплывашку с меню в шапке при наведении на ссылку \"личный кабинет\"','',0,1551841271,1552654330),(27,'Создать бэкап БД!','Чтобы был свежий всегда бэкап',1,1552542904,1552837416),(26,'оповещение на email и социальные сети','',0,1552407085,1552654330),(29,'Создать импорт файлов для товарных агрегаторов','',0,1552891279,1552891279),(30,'собрать экшен для динмических страниц','',0,1552923532,1552923532);
/*!40000 ALTER TABLE `todo_list` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `auth_key` varchar(255) DEFAULT NULL,
  `access_token` varchar(255) DEFAULT NULL,
  `email` varchar(128) DEFAULT NULL,
  `phone` bigint(20) DEFAULT NULL,
  `password` varchar(256) NOT NULL,
  `avatar` varchar(256) DEFAULT NULL,
  `vk_uid` bigint(25) DEFAULT NULL,
  `birthday` int(11) DEFAULT NULL,
  `sex` int(11) DEFAULT NULL,
  `first_name` varchar(128) DEFAULT NULL,
  `name` varchar(128) DEFAULT NULL,
  `last_name` varchar(128) DEFAULT NULL,
  `vk_link` varchar(256) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'_a4LWmjP8gifqd9c-YuLhmUz5EAkeSrd',NULL,'popugau@gmail.com',89059858726,'$2y$13$DA/3aZqa5PCvBRMaJv0oTOEX1FXHpsBZjdV/d7aThUf5L8QQBQWMW','/web/upload/4f6d5610786866c111c23996df298b7f.jpg',111815168,NULL,1,'Васин','Константин','Викторович',NULL,1549015106,1552545338);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_billing`
--

DROP TABLE IF EXISTS `user_billing`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_billing` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `street` varchar(255) DEFAULT NULL,
  `home` varchar(255) DEFAULT NULL,
  `house` varchar(255) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_billing`
--

LOCK TABLES `user_billing` WRITE;
/*!40000 ALTER TABLE `user_billing` DISABLE KEYS */;
INSERT INTO `user_billing` VALUES (1,5,'Барнаул','Весенняя','6','55',1551786962,1551787085),(2,6,'123123','123123','12','12',1551854720,1551854720),(3,1,'Барнаул','Весенняя','4','55',1551866451,1551866479),(4,10,'Баранул','Весенняя','4','232',1551887880,1551887880);
/*!40000 ALTER TABLE `user_billing` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_sex`
--

DROP TABLE IF EXISTS `user_sex`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_sex` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_sex`
--

LOCK TABLES `user_sex` WRITE;
/*!40000 ALTER TABLE `user_sex` DISABLE KEYS */;
INSERT INTO `user_sex` VALUES (1,'Мужской'),(2,'Женский');
/*!40000 ALTER TABLE `user_sex` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-03-19 10:00:01
