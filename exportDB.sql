-- MySQL dump 10.13  Distrib 5.6.17, for Win32 (x86)
--
-- Host: localhost    Database: test
-- ------------------------------------------------------
-- Server version	5.6.23-log

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
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `category` (
  `ID_category` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(65) DEFAULT NULL,
  `type` varchar(20) NOT NULL,
  `ID_user` int(11) DEFAULT NULL,
  `deleted` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`ID_category`,`type`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category`
--

LOCK TABLES `category` WRITE;
/*!40000 ALTER TABLE `category` DISABLE KEYS */;
INSERT INTO `category` VALUES (1,'elpod','o',3,'\0'),(2,'super','k',3,'\0'),(3,'fdsfsd','o',3,'\0'),(4,'fdsfds','o',3,'\0'),(5,'fdff','o',3,'\0'),(6,'hhhhhhhhhhhhh gfhf','o',3,'\0'),(7,' gfdg fdg fdgfdddddfggdfg','o',3,'\0'),(8,'fdsfdsfsd','o',3,'\0'),(9,'klk','l',3,'\0'),(10,'llllk lk lklk','l',3,'\0'),(11,'hjk hk kjhkjkjh','l',3,'\0'),(12,'fhdjskhf kjdshf kjdshf kjdsh','l',3,'\0'),(13,'jhkfdshf kjdshf','l',3,'\0'),(14,'hfjkds hkjdshf kdsjhfkjds','k',3,'\0'),(15,'dsadsa dsa','k',3,'\0'),(16,'gfgfgf','k',3,'\0'),(17,'gf gfg','k',3,'\0'),(18,'jk hkjh kjhkjhjh k','o',3,'\0'),(19,'hkjh kjhkjhkjkj','o',3,'\0'),(20,'jkljklj lkjlkjk','o',3,'\0'),(21,'jklj lk','k',3,'\0');
/*!40000 ALTER TABLE `category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `image`
--

DROP TABLE IF EXISTS `image`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `image` (
  `ID_image` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `source_name` varchar(100) DEFAULT NULL,
  `deleted` bit(1) NOT NULL DEFAULT b'0',
  `last_modified` datetime DEFAULT NULL,
  `ID_category` int(11) DEFAULT NULL,
  `priority` tinyint(1) NOT NULL DEFAULT '0',
  `ID_user` int(11) NOT NULL,
  PRIMARY KEY (`ID_image`),
  FULLTEXT KEY `name_fullindex` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `image`
--

LOCK TABLES `image` WRITE;
/*!40000 ALTER TABLE `image` DISABLE KEYS */;
INSERT INTO `image` VALUES (1,'rr JE to tady','img_550b1e2686d58.jpg','\0','2015-03-19 21:02:31',1,0,3),(2,'kll','img_550b249ae1c76.jpg','','2015-03-19 20:49:13',0,0,3),(3,'kytka','img_550b3495df55e.jpg','\0','2015-04-14 22:37:43',0,0,3),(4,'lll','img_550b349f813b4.jpg','\0','2015-03-19 21:42:08',0,0,3),(5,'pppp','img_552d7ecadb8b0.jpg','\0','2015-04-14 22:55:39',1,0,3),(6,'jkkl55','img_552d8514bd0b7.jpg','\0','2015-04-14 23:26:20',0,0,3),(7,'lk','img_552d85b71c785.jpg','','2015-04-14 23:36:39',0,0,3),(8,'oppp8','img_552d87fb46fed.jpg','\0','2015-04-14 23:35:49',0,0,3);
/*!40000 ALTER TABLE `image` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `image_tag`
--

DROP TABLE IF EXISTS `image_tag`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `image_tag` (
  `ID_imagetag` int(11) NOT NULL AUTO_INCREMENT,
  `ID_image` int(11) NOT NULL,
  `ID_tag` int(11) NOT NULL,
  PRIMARY KEY (`ID_imagetag`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `image_tag`
--

LOCK TABLES `image_tag` WRITE;
/*!40000 ALTER TABLE `image_tag` DISABLE KEYS */;
INSERT INTO `image_tag` VALUES (3,2,2),(5,1,5),(7,4,2),(8,3,71),(9,5,2),(11,7,2),(12,6,2),(14,8,2);
/*!40000 ALTER TABLE `image_tag` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `know`
--

DROP TABLE IF EXISTS `know`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `know` (
  `ID_know` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `content` varchar(1000) DEFAULT NULL,
  `last_modified` datetime NOT NULL,
  `ID_category` int(11) DEFAULT NULL,
  `priority` tinyint(1) DEFAULT '0',
  `deleted` bit(1) NOT NULL DEFAULT b'0',
  `ID_user` int(11) NOT NULL,
  PRIMARY KEY (`ID_know`),
  FULLTEXT KEY `name` (`name`,`content`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `know`
--

LOCK TABLES `know` WRITE;
/*!40000 ALTER TABLE `know` DISABLE KEYS */;
INSERT INTO `know` VALUES (1,'novyy','<p>fdsfdsfs</p>\r\n','2015-03-19 20:07:37',2,0,'\0',3),(2,'jj','<p>jjj</p>\r\n','2015-03-19 20:08:25',0,0,'\0',3),(3,'fhdjkh fkjdshf kjdshfjdkshkjshkjshkd','<p>ddjsalj dklas jdklasjd lksajdlksja dkljsakldjsakljdasjdkl</p>\r\n\r\n<p>jdkskadh as</p>\r\n','2015-03-19 23:02:01',0,1,'\0',3),(4,'hjjdk shjkhdsajk hd','<p>jjhj</p>\r\n','2015-03-19 23:02:15',0,0,'\0',3),(5,'klklkl','<p>j</p>\r\n','2015-03-19 23:08:10',0,1,'\0',3),(6,'hjk kj hkjhk','<p>hj</p>\r\n','2015-03-19 23:08:21',0,1,'\0',3),(7,'https://translate.google.com/#cs/en/raj%C4%8De','<ul>\r\n	<li><a href=\"https://translate.google.com/#cs/en/raj%C4%8De\">https://translate.google.com/#cs/en/raj%C4%8De</a></li>\r\n</ul>\r\n\r\n<p>jkhjkh</p>\r\n\r\n<p>hgj jkh</p>\r\n\r\n<p>hkuzkj</p>\r\n','2015-03-19 23:10:30',14,0,'\0',3),(8,'hjhkkj','<p>hjgh</p>\r\n','2015-03-19 23:10:51',2,0,'\0',3),(9,'hkjh k','<p>jkj</p>\r\n','2015-03-19 23:16:12',0,0,'\0',3),(10,'ghgjg','<p>mjhhkh dsfds</p>\r\n','2015-03-19 23:21:20',0,0,'\0',3),(11,'dsadsad','<p>dsadas</p>\r\n','2015-03-19 23:20:31',0,1,'\0',3),(12,'jjjj','<p>jkjkklj</p>\r\n','2015-03-26 23:16:25',2,0,'\0',3),(13,'hkkhkh','<p>jhhkkh</p>\r\n','2015-03-26 22:28:28',0,0,'\0',3),(14,'Blah','<p>jk</p>\r\n','2015-04-10 22:24:44',0,1,'',3),(15,'daksi','<p>jkjhk</p>\r\n','2015-03-26 22:49:47',14,0,'\0',3),(16,'Prdlacky','<p>fasfdsa</p>\r\n','2015-04-10 23:18:44',0,1,'\0',3),(17,'zastava','<p>hkkjlk lkjkl</p>\r\n','2015-04-10 23:20:57',0,0,'\0',3),(18,'amalka','<p>fdsafsa</p>\r\n','2015-04-10 23:39:34',0,0,'\0',3),(19,'Neco s tagz','<p>Tadz jksdjk<strong>sa joipoipdoa soi</strong></p>\r\n\r\n<p>jlkfdjalk f</p>\r\n\r\n<p>jfkldjs</p>\r\n','2015-04-13 18:43:49',2,1,'\0',3),(20,'Strasne moc tagy','<p>jkllkjjlkjljlk klj lk jlk jkl jlk jldfjas lkdjs alkjdsalk jdsklajd lksajd lksajd laksjd slakjd laskjdkl sajd lkjdklsa</p>\r\n\r\n<p>&nbsp;kkslajdklsaj dlkasjd lkas</p>\r\n','2015-04-13 19:53:03',14,1,'\0',3),(21,'Priorit','<p>fgjgfjh</p>\r\n','2015-04-13 20:38:44',2,1,'\0',3),(22,'Angelika','<p>jlkljk</p>\r\n','2015-04-13 20:41:30',2,1,'\0',3),(23,'strasne','<p>asdsad</p>\r\n','2015-04-13 21:33:05',0,0,'\0',3),(24,'extra dlouhy','<p>ss</p>\r\n','2015-04-13 21:33:36',0,0,'\0',3),(25,'fdfds','<p>aa</p>\r\n','2015-04-13 21:33:57',0,0,'\0',3),(26,'fdfds5','<p>aa</p>\r\n','2015-04-13 21:34:07',0,0,'\0',3),(27,'uuuu','<p>aass</p>\r\n','2015-04-13 21:34:31',0,0,'\0',3),(28,'uuuu','<p>aass</p>\r\n','2015-04-13 21:35:38',0,0,'\0',3),(29,'KOoo','<p>aa</p>\r\n','2015-04-13 21:44:52',0,0,'\0',3),(30,'KOoo','<p>aa</p>\r\n','2015-04-13 21:47:31',0,0,'\0',3),(31,'jlkj','<p>fdkldfslk</p>\r\n','2015-04-13 21:49:38',0,0,'\0',3),(32,'Velmi dlouhy nazev a velkmi dlouhy tag ejpe jkl jlkfjdslkjjskdfsde','<p>asdsa</p>\r\n','2015-04-13 21:51:51',0,0,'\0',3),(33,'jidjsao ijoisjdoisa jdosijd saoidjso aijdsiojdoisajlkjalk','<p>e</p>\r\n','2015-04-13 22:07:14',0,0,'\0',3),(34,'Aholk jfkdl kfjldfjieilejflfdjkldsjlmnklfdsjfliejfliejslfesj','<p>aads</p>\r\n','2015-04-13 22:09:18',0,0,'\0',3),(35,'caste kehjk djfsh hd kjdfs skjd dskj lr skd sd hjfdjhf','<p>a</p>\r\n','2015-04-13 22:11:24',0,0,'\0',3),(36,'QQQQQQQQQQQQQQQQQQQQQQQQQQQQQQQQQQQQQQQQQQQQQQQQQQQQQqqq','<p>rr</p>\r\n','2015-04-13 22:16:30',0,0,'\0',3);
/*!40000 ALTER TABLE `know` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `know_tag`
--

DROP TABLE IF EXISTS `know_tag`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `know_tag` (
  `ID_knowtag` int(11) NOT NULL AUTO_INCREMENT,
  `ID_know` int(11) NOT NULL,
  `ID_tag` int(11) NOT NULL,
  PRIMARY KEY (`ID_knowtag`)
) ENGINE=InnoDB AUTO_INCREMENT=88 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `know_tag`
--

LOCK TABLES `know_tag` WRITE;
/*!40000 ALTER TABLE `know_tag` DISABLE KEYS */;
INSERT INTO `know_tag` VALUES (2,1,2),(3,2,2),(4,3,2),(5,4,2),(6,5,2),(7,6,2),(13,7,6),(14,7,7),(15,7,8),(16,7,9),(17,7,10),(18,8,2),(19,9,2),(21,11,2),(22,10,2),(24,13,2),(25,14,2),(26,15,2),(27,12,2),(28,16,2),(29,17,2),(30,18,2),(31,19,11),(32,19,12),(33,19,13),(34,20,14),(35,20,15),(36,20,16),(37,20,17),(38,20,18),(39,20,19),(40,20,20),(41,20,21),(42,20,22),(43,21,23),(44,21,24),(45,22,2),(46,23,25),(47,23,26),(48,23,27),(49,24,28),(50,28,29),(51,28,30),(52,28,31),(53,28,32),(54,28,33),(55,28,34),(56,28,35),(57,30,36),(58,31,37),(59,32,38),(60,33,39),(61,33,11),(62,33,40),(63,33,41),(64,33,42),(65,34,43),(66,34,44),(67,34,45),(68,34,46),(69,34,47),(70,34,48),(71,34,49),(72,34,50),(73,35,51),(74,35,52),(75,35,53),(76,35,54),(77,35,55),(78,35,56),(79,35,57),(80,35,58),(81,36,59),(82,36,60),(83,36,61),(84,36,62),(85,36,63),(86,36,64),(87,36,65);
/*!40000 ALTER TABLE `know_tag` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `link`
--

DROP TABLE IF EXISTS `link`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `link` (
  `ID_link` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `URL` varchar(200) DEFAULT NULL,
  `deleted` bit(1) NOT NULL DEFAULT b'0',
  `last_modified` datetime DEFAULT NULL,
  `ID_category` int(11) DEFAULT NULL,
  `priority` tinyint(1) NOT NULL DEFAULT '0',
  `ID_user` int(11) NOT NULL,
  PRIMARY KEY (`ID_link`),
  FULLTEXT KEY `name_fullindex` (`name`,`URL`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `link`
--

LOCK TABLES `link` WRITE;
/*!40000 ALTER TABLE `link` DISABLE KEYS */;
INSERT INTO `link` VALUES (1,'jklj','hhh','\0','2015-03-19 20:09:46',0,0,3),(2,'necoo','http://fortawesome.github.io/Font-Awesome/icons/','\0','2015-03-26 23:28:22',9,1,3),(3,'jkjklj','jkjkj','\0','2015-04-10 22:24:24',12,1,3),(4,'Odkaz na google mapach kjhjkk kjk','https://www.google.com/maps/dir/37.4266842,-122.0974032/37.3128383,-122.1779059/@37.3850945,-122.1011797,12z/data=!4m2!4m1!3e0','\0','2015-04-13 22:45:59',9,1,3),(5,'','http://sfbay.craigslist.org/sby/fuo/4976231263.html','\0','2015-04-13 23:04:04',0,0,3),(6,'ss','recepty.vareni.cz','\0','2015-04-13 23:28:02',0,0,3),(7,'kk','www.fluentu.com/','\0','2015-04-13 23:28:49',0,0,3),(8,'seznam','http://seznam.cz','\0','2015-04-13 23:32:54',0,1,3),(9,'hh','http://stackoverflow.com/','\0','2015-04-13 23:33:17',0,1,3),(10,'ahoooj','http://Pokus','\0','2015-04-14 22:11:15',0,1,3);
/*!40000 ALTER TABLE `link` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `link_tag`
--

DROP TABLE IF EXISTS `link_tag`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `link_tag` (
  `ID_linktag` int(11) NOT NULL AUTO_INCREMENT,
  `ID_link` int(11) NOT NULL,
  `ID_tag` int(11) NOT NULL,
  PRIMARY KEY (`ID_linktag`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `link_tag`
--

LOCK TABLES `link_tag` WRITE;
/*!40000 ALTER TABLE `link_tag` DISABLE KEYS */;
INSERT INTO `link_tag` VALUES (1,1,2),(2,2,11),(3,3,2),(4,4,66),(5,4,67),(6,4,68),(7,4,69),(8,5,2),(9,6,2),(10,7,2),(11,8,2),(12,9,2),(13,10,70);
/*!40000 ALTER TABLE `link_tag` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tag`
--

DROP TABLE IF EXISTS `tag`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tag` (
  `ID_tag` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`ID_tag`),
  FULLTEXT KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=72 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tag`
--

LOCK TABLES `tag` WRITE;
/*!40000 ALTER TABLE `tag` DISABLE KEYS */;
INSERT INTO `tag` VALUES (1,'poster'),(2,''),(3,'ss'),(4,'k'),(5,'jk'),(6,'kjjk'),(7,'hjhjhk'),(8,'hhjjhkhk4'),(9,'jkjkhjhghggh'),(10,'hjkhkjh jkh kjh'),(11,'ahoj'),(12,'tadz'),(13,'jsem'),(14,'Karkulka'),(15,'mela'),(16,'vlka'),(17,'a ten'),(18,'ji '),(19,'pak'),(20,'snedl'),(21,'huraaa'),(22,'slunce'),(23,'jklj '),(24,' jkl'),(25,'strasne dlouhy tag co nema konec'),(26,'a taday '),(27,'jdksaljd jkldasj lkjd lkasjkdlas'),(28,'jdklsa jdlksa jdlkasjd lskajdklsalalkjkdjslkjd laksjd '),(29,'jfkd'),(30,'kjlfd'),(31,'jkfls'),(32,'iewo'),(33,'ioewj'),(34,'kd'),(35,'dkls'),(36,'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa'),(37,'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa'),(38,'ashdjkhas dkjshadkjsah djkashdlaskj'),(39,'asjkdh skjh dkasjhd jaskhd'),(40,'j'),(41,'sl'),(42,'e'),(43,'hj7'),(44,'fdjk'),(45,'ee'),(46,'z'),(47,'ymjssd'),(48,'ioasd'),(49,'oop'),(50,'ds'),(51,'hd'),(52,'iid'),(53,'jds'),(54,'nm'),(55,'ndfsj'),(56,'je'),(57,'s'),(58,'fjkd'),(59,'WWW'),(60,'QQQ'),(61,'QQQQ'),(62,'Q'),(63,'MMM'),(64,'XXX'),(65,'WW'),(66,'mapy '),(67,'gigi'),(68,'hjkhkjhjk'),(69,')jkhkj'),(70,'jj'),(71,'brouk');
/*!40000 ALTER TABLE `tag` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `ID_user` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(100) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `surname` varchar(100) DEFAULT NULL,
  `password` varchar(100) NOT NULL,
  `deleted` bit(1) DEFAULT b'0',
  PRIMARY KEY (`ID_user`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'','','','','\0'),(2,'neco','a','b','4a8a08f09d37b73795649038408b5f33','\0'),(3,'verca','verca','zolta','e01c4e6f7f2f0e56c4f1aee391f5e97c','\0');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-05-05 11:49:49
