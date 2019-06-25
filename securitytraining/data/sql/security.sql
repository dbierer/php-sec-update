-- MySQL dump 10.13  Distrib 5.7.26, for Linux (x86_64)
--
-- Host: localhost    Database: security
-- ------------------------------------------------------
-- Server version	5.7.26-0ubuntu0.18.04.1

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
-- Table structure for table `bfdetect`
--

DROP TABLE IF EXISTS `bfdetect`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bfdetect` (
  `id` bigint(3) unsigned NOT NULL AUTO_INCREMENT,
  `today` varchar(20) NOT NULL,
  `minute` varchar(3) NOT NULL,
  `ip` varchar(16) NOT NULL,
  `forward_ip` varchar(500) NOT NULL,
  `useragent` varchar(100) NOT NULL,
  `userlan` varchar(100) NOT NULL,
  `isnotify` char(1) DEFAULT '0',
  `notify4today` char(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bfdetect`
--

LOCK TABLES `bfdetect` WRITE;
/*!40000 ALTER TABLE `bfdetect` DISABLE KEYS */;
INSERT INTO `bfdetect` VALUES (1,'2017-05-26,6','50','None','None','None','None','1','1'),(2,'2017-05-26,6','50','None','None','None','None','1','1'),(3,'2017-05-26,6','50','None','None','None','None','1','1'),(4,'2017-05-26,6','50','None','None','None','None','1','1'),(5,'2017-05-26,6','55','None','None','None','None','0','1'),(6,'2019-03-4,11','30','127.0.0.1','None','Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:65.0) Gecko/20100101 Firefox/65.0','en-US,en;q=0.5','0','0');
/*!40000 ALTER TABLE `bfdetect` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(32) NOT NULL,
  `lastname` varchar(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customers`
--

LOCK TABLES `customers` WRITE;
/*!40000 ALTER TABLE `customers` DISABLE KEYS */;
INSERT INTO `customers` VALUES (1,'George','Stevenson'),(2,'Janet','Levitz'),(3,'Jason','Flores'),(4,'Susan','Chu'),(5,'Thomas','White');
/*!40000 ALTER TABLE `customers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `flowers`
--

DROP TABLE IF EXISTS `flowers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `flowers` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) DEFAULT NULL,
  `folder` varchar(255) NOT NULL,
  `type` char(8) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `flowers`
--

LOCK TABLES `flowers` WRITE;
/*!40000 ALTER TABLE `flowers` DISABLE KEYS */;
INSERT INTO `flowers` VALUES (1,'<img src=\"http://sandbox/images/hacked','http://sandbox/hack_me.php?data=<script>document.cookie</script>\" style=\"width:1px;height:1px;\" />','pink'),(2,'orange','images/','orange'),(3,'purple','images/','purple');
/*!40000 ALTER TABLE `flowers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `guestbook`
--

DROP TABLE IF EXISTS `guestbook`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `guestbook` (
  `comment_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `comment` varchar(300) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`comment_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `guestbook`
--

LOCK TABLES `guestbook` WRITE;
/*!40000 ALTER TABLE `guestbook` DISABLE KEYS */;
INSERT INTO `guestbook` VALUES (1,'Some message','ciao'),(2,'Duck dug dog, Doug dogs duck, Dog ducks Doug','who_dya_think');
/*!40000 ALTER TABLE `guestbook` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` varchar(32) NOT NULL,
  `status` varchar(16) NOT NULL,
  `amount` int(11) NOT NULL,
  `description` text NOT NULL,
  `customer` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (1,'1355097600','complete',560,'',4),(2,'1359062345','invoiced',9800,'',3),(3,'1357948800','held',300,'',2),(4,'1359500400','open',34,'Paper',3),(5,'1359586800','open',4570,'PHP development',1),(6,'1359586800','invoiced',2000,'Laptop',5),(7,'1360796400','open',300,'A big box of chocolates.',3),(8,'1361999999','hahaha',999,'<script>alert(\"UbinHackEd\");</script>',1);
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `user_id` int(6) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(15) DEFAULT NULL,
  `last_name` varchar(15) DEFAULT NULL,
  `user` varchar(15) DEFAULT NULL,
  `role` varchar(20) NOT NULL,
  `password` varchar(32) DEFAULT NULL,
  `password_zf` varchar(255) DEFAULT NULL,
  `avatar` varchar(70) DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (0,'admin','admin','admin','admin','5f4dcc3b5aa765d61d8327deb882cf99','$2y$10$2Hbz2Rpd/F1/Ow8bu5eL.OW9LUEBx3wWSp7JwnkmC/fU7ErN95cYq','admin.jpg'),(1,'Gordon','Brown','gordonb','user','e99a18c428cb38d5f260853678922e03','$2y$14$AILkLSmDvPYMV/XGb8Lk2ejsXamIre02iOYF7x3KqkIigFhRVEKd6','gordonb.jpg'),(2,'Hack','Me','1337','guest','8d3533d75ae2c3966d7e0d4fcc69216b','$2y$14$O9AxZdEa7TSGS//KPgBwseTTfv3owgjIYvOI4cjEmA2RQbeirF78y','1337.jpg'),(3,'Pablo','Picasso','pablo','guest','0d107d09f5bbe40cade3de5c71e9e9b7','$2y$14$4mc/sICI5gR2MOrvFZWSsuQB0SYiYX012YtVpOoq.//wQe4PD/uxi','pablo.jpg'),(4,'Bob','Smith','smithy','guest','5f4dcc3b5aa765d61d8327deb882cf99','$2y$14$ZYLvxIde2JhXPMDTDVZPAe5WwRQxulXz9aOoZlmtlPvA1IprjSAmm','smithy.jpg');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'security'
--

--
-- Dumping routines for database 'security'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-06-25 11:07:47
