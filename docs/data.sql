/*
SQLyog Enterprise - MySQL GUI v8.05 
MySQL - 5.6.21 : Database - translate
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

CREATE DATABASE /*!32312 IF NOT EXISTS*/`translate` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci */;

USE `translate`;

/*Table structure for table `admin` */

DROP TABLE IF EXISTS `admin`;

CREATE TABLE `admin` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `admin` */

insert  into `admin`(`id`,`username`,`password`,`name`,`created`,`modified`) values (1,'admin','123456','admin','0000-00-00 00:00:00','0000-00-00 00:00:00');

/*Table structure for table `countries` */

DROP TABLE IF EXISTS `countries`;

CREATE TABLE `countries` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `countries` */

insert  into `countries`(`id`,`name`,`created`,`modified`) values (1,'A',NULL,NULL);
insert  into `countries`(`id`,`name`,`created`,`modified`) values (2,'B',NULL,NULL);
insert  into `countries`(`id`,`name`,`created`,`modified`) values (3,'C',NULL,NULL);
insert  into `countries`(`id`,`name`,`created`,`modified`) values (4,'F',NULL,NULL);
insert  into `countries`(`id`,`name`,`created`,`modified`) values (5,'G',NULL,NULL);
insert  into `countries`(`id`,`name`,`created`,`modified`) values (6,'H',NULL,NULL);
insert  into `countries`(`id`,`name`,`created`,`modified`) values (7,'I',NULL,NULL);
insert  into `countries`(`id`,`name`,`created`,`modified`) values (8,'J',NULL,NULL);
insert  into `countries`(`id`,`name`,`created`,`modified`) values (9,'L',NULL,NULL);
insert  into `countries`(`id`,`name`,`created`,`modified`) values (10,'M',NULL,NULL);
insert  into `countries`(`id`,`name`,`created`,`modified`) values (11,'O',NULL,NULL);
insert  into `countries`(`id`,`name`,`created`,`modified`) values (12,'P',NULL,NULL);
insert  into `countries`(`id`,`name`,`created`,`modified`) values (13,'Q',NULL,NULL);
insert  into `countries`(`id`,`name`,`created`,`modified`) values (14,'R',NULL,NULL);
insert  into `countries`(`id`,`name`,`created`,`modified`) values (15,'S',NULL,NULL);
insert  into `countries`(`id`,`name`,`created`,`modified`) values (16,'T',NULL,NULL);
insert  into `countries`(`id`,`name`,`created`,`modified`) values (17,'U',NULL,NULL);
insert  into `countries`(`id`,`name`,`created`,`modified`) values (18,'V',NULL,NULL);

/*Table structure for table `detail_countries` */

DROP TABLE IF EXISTS `detail_countries`;

CREATE TABLE `detail_countries` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `country_id` int(11) DEFAULT NULL,
  `key_country` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name_country` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `detail_countries` */

insert  into `detail_countries`(`id`,`country_id`,`key_country`,`name_country`,`created`,`modified`) values (1,1,'+61','Australia',NULL,NULL);
insert  into `detail_countries`(`id`,`country_id`,`key_country`,`name_country`,`created`,`modified`) values (2,1,'+224','Angola',NULL,NULL);
insert  into `detail_countries`(`id`,`country_id`,`key_country`,`name_country`,`created`,`modified`) values (3,2,'+32','Belgium',NULL,NULL);
insert  into `detail_countries`(`id`,`country_id`,`key_country`,`name_country`,`created`,`modified`) values (4,3,'+1','Canada',NULL,NULL);
insert  into `detail_countries`(`id`,`country_id`,`key_country`,`name_country`,`created`,`modified`) values (5,3,'+420','Czech Republic',NULL,NULL);
insert  into `detail_countries`(`id`,`country_id`,`key_country`,`name_country`,`created`,`modified`) values (6,3,'+86','China',NULL,NULL);
insert  into `detail_countries`(`id`,`country_id`,`key_country`,`name_country`,`created`,`modified`) values (7,3,'+855','Cambodia',NULL,NULL);
insert  into `detail_countries`(`id`,`country_id`,`key_country`,`name_country`,`created`,`modified`) values (8,4,'+33','France',NULL,NULL);
insert  into `detail_countries`(`id`,`country_id`,`key_country`,`name_country`,`created`,`modified`) values (9,5,'+49','Germany',NULL,NULL);
insert  into `detail_countries`(`id`,`country_id`,`key_country`,`name_country`,`created`,`modified`) values (10,6,'+852','Hong Kong',NULL,NULL);
insert  into `detail_countries`(`id`,`country_id`,`key_country`,`name_country`,`created`,`modified`) values (11,7,'+62','Indonesia',NULL,NULL);
insert  into `detail_countries`(`id`,`country_id`,`key_country`,`name_country`,`created`,`modified`) values (12,8,'+81','Japan',NULL,NULL);
insert  into `detail_countries`(`id`,`country_id`,`key_country`,`name_country`,`created`,`modified`) values (13,9,'+82','Laos',NULL,NULL);
insert  into `detail_countries`(`id`,`country_id`,`key_country`,`name_country`,`created`,`modified`) values (14,10,'+853','Macau',NULL,NULL);
insert  into `detail_countries`(`id`,`country_id`,`key_country`,`name_country`,`created`,`modified`) values (15,10,'+60','Malaysia',NULL,NULL);
insert  into `detail_countries`(`id`,`country_id`,`key_country`,`name_country`,`created`,`modified`) values (16,11,'+968','Oman',NULL,NULL);
insert  into `detail_countries`(`id`,`country_id`,`key_country`,`name_country`,`created`,`modified`) values (17,12,'+48','Polan',NULL,NULL);
insert  into `detail_countries`(`id`,`country_id`,`key_country`,`name_country`,`created`,`modified`) values (18,12,'+63','Philippines',NULL,NULL);
insert  into `detail_countries`(`id`,`country_id`,`key_country`,`name_country`,`created`,`modified`) values (19,13,'+974','Quatar',NULL,NULL);
insert  into `detail_countries`(`id`,`country_id`,`key_country`,`name_country`,`created`,`modified`) values (20,14,'+7','Russian Federation',NULL,NULL);
insert  into `detail_countries`(`id`,`country_id`,`key_country`,`name_country`,`created`,`modified`) values (21,15,'+82','South Korea',NULL,NULL);
insert  into `detail_countries`(`id`,`country_id`,`key_country`,`name_country`,`created`,`modified`) values (22,15,'+65','Singapore',NULL,NULL);
insert  into `detail_countries`(`id`,`country_id`,`key_country`,`name_country`,`created`,`modified`) values (23,15,'+966','Saudi Arabia',NULL,NULL);
insert  into `detail_countries`(`id`,`country_id`,`key_country`,`name_country`,`created`,`modified`) values (24,16,'+886','Taiwan',NULL,NULL);
insert  into `detail_countries`(`id`,`country_id`,`key_country`,`name_country`,`created`,`modified`) values (25,16,'+66','Thailand',NULL,NULL);
insert  into `detail_countries`(`id`,`country_id`,`key_country`,`name_country`,`created`,`modified`) values (26,17,'+971','United Arab Emirates',NULL,NULL);
insert  into `detail_countries`(`id`,`country_id`,`key_country`,`name_country`,`created`,`modified`) values (27,17,'+1','United States',NULL,NULL);
insert  into `detail_countries`(`id`,`country_id`,`key_country`,`name_country`,`created`,`modified`) values (28,17,'+41','United KingDom',NULL,NULL);
insert  into `detail_countries`(`id`,`country_id`,`key_country`,`name_country`,`created`,`modified`) values (29,18,'+84','VietNam',NULL,NULL);

/*Table structure for table `histories` */

DROP TABLE IF EXISTS `histories`;

CREATE TABLE `histories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `value_buy` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `histories` */

insert  into `histories`(`id`,`user_id`,`value_buy`,`created`,`modified`) values (1,3,54,'2015-10-01 00:47:49','2015-10-01 00:47:49');
insert  into `histories`(`id`,`user_id`,`value_buy`,`created`,`modified`) values (2,3,25,'2015-10-01 00:48:00','2015-10-01 00:48:00');
insert  into `histories`(`id`,`user_id`,`value_buy`,`created`,`modified`) values (3,1,20,'2015-10-01 00:56:24','2015-10-01 00:56:24');
insert  into `histories`(`id`,`user_id`,`value_buy`,`created`,`modified`) values (4,1,30,'2015-10-01 00:56:32','2015-10-01 00:56:32');
insert  into `histories`(`id`,`user_id`,`value_buy`,`created`,`modified`) values (6,1,252,'2015-10-01 01:27:21','2015-10-01 01:27:21');
insert  into `histories`(`id`,`user_id`,`value_buy`,`created`,`modified`) values (7,1,84,'2015-10-01 01:27:24','2015-10-01 01:27:24');
insert  into `histories`(`id`,`user_id`,`value_buy`,`created`,`modified`) values (8,1,720,'2015-10-01 11:26:01','2015-10-01 11:26:01');
insert  into `histories`(`id`,`user_id`,`value_buy`,`created`,`modified`) values (9,1,840,'2015-10-01 11:26:12','2015-10-01 11:26:12');
insert  into `histories`(`id`,`user_id`,`value_buy`,`created`,`modified`) values (10,1,720,'2015-10-01 11:26:20','2015-10-01 11:26:20');
insert  into `histories`(`id`,`user_id`,`value_buy`,`created`,`modified`) values (11,1,600,'2015-10-01 11:26:30','2015-10-01 11:26:30');

/*Table structure for table `questions` */

DROP TABLE IF EXISTS `questions`;

CREATE TABLE `questions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `content` text COLLATE utf8_unicode_ci,
  `reply` text COLLATE utf8_unicode_ci,
  `length` int(11) DEFAULT NULL,
  `is_read` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `questions` */

insert  into `questions`(`id`,`user_id`,`content`,`reply`,`length`,`is_read`,`created`,`modified`) values (7,1,'翻訳依頼一覧翻訳依頼一覧翻訳依頼一覧','AAAB\r\nCCC',21,1,'2015-10-01 00:06:29','2015-10-01 00:06:29');
insert  into `questions`(`id`,`user_id`,`content`,`reply`,`length`,`is_read`,`created`,`modified`) values (8,1,'ebđb kcn nvj f\nvk kf kfk j nvffnn \nfff',NULL,38,1,'2015-10-01 00:06:44','2015-10-01 00:06:44');
insert  into `questions`(`id`,`user_id`,`content`,`reply`,`length`,`is_read`,`created`,`modified`) values (9,1,'demo','A',4,1,'2015-10-01 01:31:03','2015-10-01 01:31:03');
insert  into `questions`(`id`,`user_id`,`content`,`reply`,`length`,`is_read`,`created`,`modified`) values (10,3,'dj nn c\n mcmnc \ncncnc',NULL,21,1,'2015-10-01 01:52:45','2015-10-01 01:52:45');
insert  into `questions`(`id`,`user_id`,`content`,`reply`,`length`,`is_read`,`created`,`modified`) values (11,3,'cn ncn jcj n \nfjf j kfk  \nckvk kck k kvkk k k kfkckv kfjfj kck k k k kkfk k kvkvj  k kvkvk kck',NULL,94,1,'2015-10-01 11:39:25','2015-10-01 11:39:25');

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `phone` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password_change` int(11) DEFAULT NULL,
  `detail_countries_id` int(11) DEFAULT NULL,
  `user_code` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `use_value` int(11) DEFAULT NULL,
  `lat` double DEFAULT NULL,
  `lng` double DEFAULT NULL,
  `device_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `badge` int(11) DEFAULT NULL,
  `is_block` int(11) DEFAULT NULL,
  `deleted_flg` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `users` */

insert  into `users`(`id`,`phone`,`password`,`password_change`,`detail_countries_id`,`user_code`,`name`,`email`,`use_value`,`lat`,`lng`,`device_token`,`badge`,`is_block`,`deleted_flg`,`created`,`modified`) values (1,'+841297557909','123456',0,3,'915940','thai123','abc@gmail.con',3137,NULL,NULL,NULL,NULL,0,0,'2015-09-30 13:37:02','2015-09-30 13:37:02');
insert  into `users`(`id`,`phone`,`password`,`password_change`,`detail_countries_id`,`user_code`,`name`,`email`,`use_value`,`lat`,`lng`,`device_token`,`badge`,`is_block`,`deleted_flg`,`created`,`modified`) values (3,'+841297557908','319239',0,29,'073268',NULL,NULL,0,NULL,NULL,NULL,NULL,1,0,'2015-09-30 15:40:13','2015-09-30 15:40:13');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
