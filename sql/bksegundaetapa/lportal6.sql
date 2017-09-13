/*
SQLyog Ultimate v8.71 
MySQL - 5.5.5-10.1.13-MariaDB : Database - lportal6
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`lportal6` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `lportal6`;

/*Table structure for table `Contact_` */

DROP TABLE IF EXISTS `Contact_`;

CREATE TABLE `Contact_` (
  `userId` bigint(20) DEFAULT NULL,
  `birthday` datetime DEFAULT NULL,
  `male` tinyint(4) DEFAULT NULL,
  `modifiedDate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `Contact_` */

insert  into `Contact_`(`userId`,`birthday`,`male`,`modifiedDate`) values (175548,'1950-08-16 00:00:00',1,'2017-05-22 12:06:29'),(172213,'1990-03-05 00:00:00',1,'2017-06-15 14:43:00');

/*Table structure for table `User_` */

DROP TABLE IF EXISTS `User_`;

CREATE TABLE `User_` (
  `userId` bigint(20) DEFAULT NULL,
  `dni` varchar(8) DEFAULT NULL,
  `num_doc` varchar(9) DEFAULT NULL,
  `tipo_doc` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `User_` */

insert  into `User_`(`userId`,`dni`,`num_doc`,`tipo_doc`) values (175548,'43375719',NULL,'2'),(172213,'41843115',NULL,'2');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
