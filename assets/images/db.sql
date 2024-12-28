/*
SQLyog Ultimate v13.1.1 (64 bit)
MySQL - 10.4.14-MariaDB : Database - real_state_masterfile
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`real_state_masterfile` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

USE `real_state_masterfile`;

/*Table structure for table `agent_ids` */

DROP TABLE IF EXISTS `agent_ids`;

CREATE TABLE `agent_ids` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `agent_id` int(11) DEFAULT NULL,
  `filename` varchar(100) DEFAULT NULL,
  `remarks` varchar(25) DEFAULT 'Unvalidated',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4;

/*Data for the table `agent_ids` */

/*Table structure for table `agents` */

DROP TABLE IF EXISTS `agents`;

CREATE TABLE `agents` (
  `agent_id` int(11) NOT NULL,
  `fullname` varchar(75) DEFAULT NULL,
  `contact_no` varchar(100) DEFAULT NULL,
  `email_address` varchar(50) DEFAULT NULL,
  `password` varbinary(70) DEFAULT NULL,
  `1st_verification` varchar(25) DEFAULT 'Unverified',
  `2nd_verification` varchar(25) DEFAULT 'Unverified',
  `registration_date` datetime DEFAULT current_timestamp(),
  `profile_img` varchar(100) DEFAULT 'assets/images/unknown.png',
  PRIMARY KEY (`agent_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `agents` */

/*Table structure for table `notifications` */

DROP TABLE IF EXISTS `notifications`;

CREATE TABLE `notifications` (
  `notification_id` int(11) NOT NULL,
  `_to` int(50) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `remarks` varchar(25) DEFAULT 'Unread',
  PRIMARY KEY (`notification_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `notifications` */

/*Table structure for table `properties` */

DROP TABLE IF EXISTS `properties`;

CREATE TABLE `properties` (
  `property_id` int(11) DEFAULT NULL,
  `agent_id` int(11) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `address` varchar(150) DEFAULT NULL,
  `price` int(11) NOT NULL,
  `map_latitude` double DEFAULT NULL,
  `map_longitude` double DEFAULT NULL,
  `cover_img` varchar(100) DEFAULT NULL,
  `show_to_clients` varchar(11) DEFAULT 'No'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `properties` */

/*Table structure for table `property_amenities` */

DROP TABLE IF EXISTS `property_amenities`;

CREATE TABLE `property_amenities` (
  `amenity_id` int(11) NOT NULL AUTO_INCREMENT,
  `property_id` int(11) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`amenity_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;

/*Data for the table `property_amenities` */

/*Table structure for table `property_views` */

DROP TABLE IF EXISTS `property_views`;

CREATE TABLE `property_views` (
  `view_id` int(11) NOT NULL AUTO_INCREMENT,
  `property_id` int(11) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `image_count` int(11) DEFAULT NULL,
  PRIMARY KEY (`view_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1715653914 DEFAULT CHARSET=utf8mb4;

/*Data for the table `property_views` */

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `account_name` varchar(50) NOT NULL,
  `username` varchar(25) NOT NULL,
  `password` varchar(75) NOT NULL,
  `user_type` varchar(50) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `users` */

insert  into `users`(`user_id`,`account_name`,`username`,`password`,`user_type`) values 
(1713322784,'Admin','admin','123456','Admin');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
