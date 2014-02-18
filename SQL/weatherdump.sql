-- MySQL dump 10.13  Distrib 5.6.11, for osx10.7 (x86_64)
--
-- Host: localhost    Database: weather
-- ------------------------------------------------------
-- Server version	5.6.11

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
-- Table structure for table `weather_agent`
--

DROP TABLE IF EXISTS `weather_agent`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `weather_agent` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `agent` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `weather_agent`
--

LOCK TABLES `weather_agent` WRITE;
/*!40000 ALTER TABLE `weather_agent` DISABLE KEYS */;
INSERT INTO `weather_agent` VALUES (1,'Opera/9.80 (Windows NT 6.0) Presto/2.12.388 Version/12.14'),(2,'Mozilla/5.0 (Windows NT 6.0; rv:2.0) Gecko/20100101 Firefox/4.0 Opera 12.14'),(3,'Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.0) Opera 12.14'),(4,'Mozilla/5.0 (Windows NT 6.2; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/32.0.1667.0 Safari/537.36'),(5,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/32.0.1664.3 Safari/537.36'),(6,'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.16 Safari/537.36'),(7,'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1623.0 Safari/537.36'),(8,'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/30.0.1599.17 Safari/537.36'),(9,'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/29.0.1547.62 Safari/537.36'),(10,'Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:25.0) Gecko/20100101 Firefox/25.0'),(11,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:25.0) Gecko/20100101 Firefox/25.0'),(12,'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:24.0) Gecko/20100101 Firefox/24.0'),(13,'Mozilla/5.0 (Windows NT 6.0; WOW64; rv:24.0) Gecko/20100101 Firefox/24.0'),(14,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.8; rv:24.0) Gecko/20100101 Firefox/24.0'),(15,'Mozilla/5.0 (Windows NT 6.2; rv:22.0) Gecko/20130405 Firefox/23.0'),(16,'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:23.0) Gecko/20130406 Firefox/23.0'),(17,'Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:23.0) Gecko/20131011 Firefox/23.0'),(18,'Mozilla/5.0 (Windows NT 6.2; rv:22.0) Gecko/20130405 Firefox/22.0'),(19,'Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:22.0) Gecko/20130328 Firefox/22.0'),(20,'Mozilla/5.0 (Windows NT 6.1; rv:22.0) Gecko/20130405 Firefox/22.0'),(21,'Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.1; WOW64; Trident/6.0)'),(22,'Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.1; Trident/6.0)'),(23,'Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.1; Trident/5.0)'),(24,'Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.1; Trident/4.0; InfoPath.2; SV1; .NET CLR 2.0.50727; WOW64)'),(25,'Mozilla/4.0 (compatible; MSIE 10.0; Windows NT 6.1; Trident/5.0)'),(26,'Mozilla/1.22 (compatible; MSIE 10.0; Windows 3.1)'),(27,'Mozilla/5.0 (Windows; U; MSIE 9.0; Windows NT 9.0; en-US)'),(28,'Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 7.1; Trident/5.0)'),(29,'Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; WOW64; Trident/5.0; SLCC2; Media Center PC 6.0; InfoPath.3; MS-RTC LM 8; Zune 4.7)'),(30,'Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; WOW64; Trident/5.0; SLCC2; Media Center PC 6.0; InfoPath.3; MS-RTC LM 8; Zune 4.7'),(31,'Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; WOW64; Trident/5.0; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0; Zune 4.0; InfoPath.3; MS-RTC LM 8; .NET4.0C; .NET4.0E)'),(32,'Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; WOW64; Trident/5.0; chromeframe/12.0.742.112)'),(33,'Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; WOW64; Trident/5.0; .NET CLR 3.5.30729; .NET CLR 3.0.30729; .NET CLR 2.0.50727; Media Center PC 6.0)'),(34,'Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; Win64; x64; Trident/5.0; .NET CLR 3.5.30729; .NET CLR 3.0.30729; .NET CLR 2.0.50727; Media Center PC 6.0)'),(35,'Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; Win64; x64; Trident/5.0; .NET CLR 2.0.50727; SLCC2; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0; Zune 4.0; Tablet PC 2.0; InfoPath.3; .NET4.0C; .NET4.0E)'),(36,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_8) AppleWebKit/536.15 (KHTML, like Gecko) iCab/5.0 Safari/533.16'),(37,'Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10_6_7; nn-no) AppleWebKit/533.21.1 (KHTML, like Gecko) iCab/4.8b Safari/533.16');
/*!40000 ALTER TABLE `weather_agent` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `weather_forecast`
--

DROP TABLE IF EXISTS `weather_forecast`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `weather_forecast` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` tinyint(3) unsigned DEFAULT NULL,
  `scrape_date` date DEFAULT NULL,
  `forecast_date` date DEFAULT NULL,
  `high` tinyint(4) DEFAULT NULL,
  `high_unit` char(1) NOT NULL DEFAULT 'C',
  `low` tinyint(4) DEFAULT NULL,
  `low_unit` char(1) NOT NULL DEFAULT 'C',
  `rain_amount` decimal(4,1) DEFAULT NULL,
  `rain_unit` char(2) DEFAULT 'mm',
  `snow_amount` decimal(4,1) DEFAULT NULL,
  `snow_unit` char(2) DEFAULT 'cm',
  `chance_of_precip` tinyint(3) unsigned DEFAULT NULL,
  `precip_amount` decimal(5,2) DEFAULT NULL,
  `precip_unit` char(2) DEFAULT 'mm',
  `wind_speed` tinyint(3) unsigned DEFAULT NULL,
  `wind_unit` varchar(4) DEFAULT 'km/h',
  `wind_direction` smallint(5) unsigned DEFAULT NULL,
  `humidity` tinyint(3) unsigned DEFAULT NULL,
  `prose_forecast` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `site_id` (`site_id`,`scrape_date`,`forecast_date`)
) ENGINE=InnoDB AUTO_INCREMENT=102 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `weather_forecast`
--

LOCK TABLES `weather_forecast` WRITE;
/*!40000 ALTER TABLE `weather_forecast` DISABLE KEYS */;
INSERT INTO `weather_forecast` VALUES (1,7,'2014-02-17','2014-02-17',1,'C',-9,'C',NULL,'mm',0.0,'cm',NULL,0.00,'mm',NULL,NULL,NULL,NULL,'Warmer with clouds and sun'),(2,7,'2014-02-17','2014-02-18',-1,'C',-12,'C',NULL,'mm',0.2,'cm',NULL,0.00,'mm',NULL,NULL,NULL,NULL,'Partly sunny'),(3,7,'2014-02-17','2014-02-19',-1,'C',-19,'C',NULL,'mm',1.8,'cm',NULL,1.00,'mm',NULL,NULL,NULL,NULL,'Mostly cloudy, a bit of snow'),(4,7,'2014-02-17','2014-02-20',-7,'C',-21,'C',NULL,'mm',0.0,'cm',NULL,0.00,'mm',NULL,NULL,NULL,NULL,'Colder with clouds and sun'),(5,7,'2014-02-17','2014-02-21',-12,'C',-20,'C',NULL,'mm',0.1,'cm',NULL,0.00,'mm',NULL,NULL,NULL,NULL,'Frigid with clouds and sun'),(6,7,'2014-02-17','2014-02-22',-10,'C',-21,'C',NULL,'mm',0.0,'cm',NULL,0.00,'mm',NULL,NULL,NULL,NULL,'Partly sunny and frigid'),(7,7,'2014-02-17','2014-02-23',-12,'C',-15,'C',NULL,'mm',3.4,'cm',NULL,1.00,'mm',NULL,NULL,NULL,NULL,'Frigid with a little snow'),(8,7,'2014-02-17','2014-02-24',-10,'C',-13,'C',NULL,'mm',0.0,'cm',NULL,0.00,'mm',NULL,NULL,NULL,NULL,'Plenty of sun, but frigid'),(9,7,'2014-02-17','2014-02-25',-4,'C',-15,'C',NULL,'mm',0.0,'cm',NULL,0.00,'mm',NULL,NULL,NULL,NULL,'Plenty of sun'),(10,7,'2014-02-17','2014-02-26',-9,'C',-17,'C',NULL,'mm',0.0,'cm',NULL,0.00,'mm',NULL,NULL,NULL,NULL,'Sunshine and bitterly cold'),(11,7,'2014-02-17','2014-02-27',-8,'C',-18,'C',NULL,'mm',0.0,'cm',NULL,0.00,'mm',NULL,NULL,NULL,NULL,'Cold with sunshine'),(12,7,'2014-02-17','2014-02-28',-5,'C',-11,'C',NULL,'mm',0.0,'cm',NULL,0.00,'mm',NULL,NULL,NULL,NULL,'Sunshine and not as cold'),(13,7,'2014-02-17','2014-03-01',-8,'C',-15,'C',NULL,'mm',0.0,'cm',NULL,0.00,'mm',NULL,NULL,NULL,NULL,'Clouds break for sun; cold'),(14,7,'2014-02-17','2014-03-02',-8,'C',-20,'C',NULL,'mm',0.0,'cm',NULL,0.00,'mm',NULL,NULL,NULL,NULL,'Cold with clouds and sunshine'),(15,7,'2014-02-17','2014-03-03',-10,'C',-18,'C',NULL,'mm',0.0,'cm',NULL,0.00,'mm',NULL,NULL,NULL,NULL,'Partly sunny and very cold'),(16,7,'2014-02-17','2014-03-04',-7,'C',-18,'C',NULL,'mm',1.7,'cm',NULL,1.00,'mm',NULL,NULL,NULL,NULL,'Cold with plenty of clouds'),(17,7,'2014-02-17','2014-03-05',-7,'C',-18,'C',NULL,'mm',0.0,'cm',NULL,0.00,'mm',NULL,NULL,NULL,NULL,'Cold with considerable clouds'),(18,7,'2014-02-17','2014-03-06',0,'C',-10,'C',NULL,'mm',0.0,'cm',NULL,0.00,'mm',NULL,NULL,NULL,NULL,'Turning out cloudy'),(19,7,'2014-02-17','2014-03-07',2,'C',-8,'C',NULL,'mm',0.0,'cm',NULL,0.00,'mm',NULL,NULL,NULL,NULL,'Sunshine and some clouds'),(20,7,'2014-02-17','2014-03-08',2,'C',-8,'C',NULL,'mm',0.0,'cm',NULL,0.00,'mm',NULL,NULL,NULL,NULL,'Cloudy'),(21,7,'2014-02-17','2014-03-09',2,'C',-9,'C',NULL,'mm',0.0,'cm',NULL,0.00,'mm',NULL,NULL,NULL,NULL,'Cloudy'),(22,7,'2014-02-17','2014-03-10',0,'C',-10,'C',NULL,'mm',0.0,'cm',NULL,0.00,'mm',NULL,NULL,NULL,NULL,'Increasing cloudiness'),(23,7,'2014-02-17','2014-03-11',1,'C',-7,'C',NULL,'mm',0.0,'cm',NULL,0.00,'mm',NULL,NULL,NULL,NULL,'Sun and clouds'),(24,7,'2014-02-17','2014-03-12',3,'C',-8,'C',NULL,'mm',0.0,'cm',NULL,0.00,'mm',NULL,NULL,NULL,NULL,'Overcast'),(25,7,'2014-02-17','2014-03-13',-1,'C',-12,'C',NULL,'mm',0.0,'cm',NULL,0.00,'mm',NULL,NULL,NULL,NULL,'Sunshine'),(26,7,'2014-02-17','2014-03-14',-3,'C',-11,'C',NULL,'mm',0.0,'cm',NULL,0.00,'mm',NULL,NULL,NULL,NULL,'Mostly sunny'),(27,7,'2014-02-17','2014-03-15',1,'C',-7,'C',NULL,'mm',0.0,'cm',NULL,0.00,'mm',NULL,NULL,NULL,NULL,'Thickening clouds'),(28,7,'2014-02-17','2014-03-16',5,'C',-5,'C',NULL,'mm',0.0,'cm',NULL,0.00,'mm',NULL,NULL,NULL,NULL,'Mostly sunny'),(29,7,'2014-02-17','2014-03-17',5,'C',-5,'C',NULL,'mm',0.0,'cm',NULL,0.00,'mm',NULL,NULL,NULL,NULL,'Mostly sunny'),(30,7,'2014-02-17','2014-03-18',4,'C',-8,'C',NULL,'mm',0.8,'cm',NULL,1.00,'mm',NULL,NULL,NULL,NULL,'Mostly cloudy, snow showers'),(31,7,'2014-02-17','2014-03-19',0,'C',-13,'C',NULL,'mm',0.3,'cm',NULL,0.00,'mm',NULL,NULL,NULL,NULL,'Cloudy, flurries; colder'),(32,7,'2014-02-17','2014-03-20',-3,'C',-13,'C',NULL,'mm',0.0,'cm',NULL,0.00,'mm',NULL,NULL,NULL,NULL,'Cloudy and cold'),(33,7,'2014-02-17','2014-03-21',-2,'C',-12,'C',NULL,'mm',0.0,'cm',NULL,0.00,'mm',NULL,NULL,NULL,NULL,'Partly sunny'),(34,7,'2014-02-17','2014-03-22',-1,'C',-8,'C',NULL,'mm',0.1,'cm',NULL,0.00,'mm',NULL,NULL,NULL,NULL,'Mostly sunny'),(35,7,'2014-02-17','2014-03-23',2,'C',-5,'C',NULL,'mm',0.2,'cm',NULL,0.00,'mm',NULL,NULL,NULL,NULL,'Clouds and sun with flurries'),(36,7,'2014-02-17','2014-03-24',1,'C',-6,'C',NULL,'mm',0.3,'cm',NULL,0.00,'mm',NULL,NULL,NULL,NULL,'Cloudy with a few snowflakes'),(37,7,'2014-02-17','2014-03-25',0,'C',-8,'C',NULL,'mm',0.1,'cm',NULL,0.00,'mm',NULL,NULL,NULL,NULL,'Mostly cloudy with a flurry'),(38,7,'2014-02-17','2014-03-26',4,'C',-3,'C',NULL,'mm',0.0,'cm',NULL,0.00,'mm',NULL,NULL,NULL,NULL,'Warmer with some sun'),(39,7,'2014-02-17','2014-03-27',5,'C',-3,'C',NULL,'mm',0.1,'cm',NULL,0.00,'mm',NULL,NULL,NULL,NULL,'Clouds and sun'),(40,7,'2014-02-17','2014-03-28',3,'C',-3,'C',NULL,'mm',0.2,'cm',NULL,0.00,'mm',NULL,NULL,NULL,NULL,'Cloudy with a few flurries'),(41,7,'2014-02-17','2014-03-29',5,'C',-2,'C',NULL,'mm',0.0,'cm',NULL,0.00,'mm',NULL,NULL,NULL,NULL,'Cloudy'),(42,7,'2014-02-17','2014-03-30',9,'C',-2,'C',NULL,'mm',0.0,'cm',NULL,0.00,'mm',NULL,NULL,NULL,NULL,'Warmer with clouds and sun'),(43,7,'2014-02-17','2014-03-31',9,'C',-2,'C',NULL,'mm',0.0,'cm',NULL,1.00,'mm',NULL,NULL,NULL,NULL,'Times of clouds and sun'),(44,7,'2014-02-17','2014-04-01',8,'C',-2,'C',NULL,'mm',0.0,'cm',NULL,3.00,'mm',NULL,NULL,NULL,NULL,'Mainly cloudy, showers around'),(45,7,'2014-02-17','2014-04-02',4,'C',-2,'C',NULL,'mm',0.0,'cm',NULL,0.00,'mm',NULL,NULL,NULL,NULL,'Mostly cloudy'),(46,11,'2014-02-17','2014-02-17',NULL,'C',-7,'C',NULL,'mm',NULL,'cm',NULL,NULL,'mm',NULL,NULL,NULL,NULL,NULL),(47,11,'2014-02-17','2014-02-18',2,'C',NULL,'C',NULL,'mm',NULL,'cm',NULL,NULL,'mm',NULL,NULL,NULL,NULL,'Mainly sunny. Wind west 20 km/h becoming light in the morning. High plus 2.'),(48,11,'2014-02-17','2014-02-19',-3,'C',-6,'C',NULL,'mm',NULL,'cm',NULL,NULL,'mm',NULL,NULL,NULL,NULL,'A mix of sun and cloud. High minus 3.'),(49,11,'2014-02-17','2014-02-20',-8,'C',-13,'C',NULL,'mm',NULL,'cm',NULL,NULL,'mm',NULL,NULL,NULL,NULL,'A mix of sun and cloud. Low minus 13. High minus 8.'),(50,11,'2014-02-17','2014-02-21',-9,'C',-18,'C',NULL,'mm',NULL,'cm',NULL,NULL,'mm',NULL,NULL,NULL,NULL,'Sunny. Low minus 18. High minus 9.'),(51,11,'2014-02-17','2014-02-22',-7,'C',-11,'C',NULL,'mm',NULL,'cm',NULL,NULL,'mm',NULL,NULL,NULL,NULL,'A mix of sun and cloud. Low minus 11. High minus 7.'),(52,12,'2014-02-17','2014-02-17',NULL,'C',-10,'C',NULL,'mm',NULL,'cm',NULL,NULL,'mm',NULL,NULL,NULL,NULL,NULL),(53,12,'2014-02-17','2014-02-18',-1,'C',NULL,'C',NULL,'mm',NULL,'cm',NULL,NULL,'mm',NULL,NULL,NULL,NULL,'Mainly sunny. High minus 1.'),(54,12,'2014-02-17','2014-02-19',-4,'C',-7,'C',NULL,'mm',NULL,'cm',NULL,NULL,'mm',NULL,NULL,NULL,NULL,'Sunny. High minus 4.'),(55,12,'2014-02-17','2014-02-20',-9,'C',-16,'C',NULL,'mm',NULL,'cm',NULL,NULL,'mm',NULL,NULL,NULL,NULL,'A mix of sun and cloud. Low minus 16. High minus 9.'),(56,12,'2014-02-17','2014-02-21',-10,'C',-21,'C',NULL,'mm',NULL,'cm',NULL,NULL,'mm',NULL,NULL,NULL,NULL,'Sunny. Low minus 21. High minus 10.'),(57,12,'2014-02-17','2014-02-22',-6,'C',-14,'C',NULL,'mm',NULL,'cm',NULL,NULL,'mm',NULL,NULL,NULL,NULL,'A mix of sun and cloud. Low minus 14. High minus 6.'),(58,4,'2014-02-17','2014-02-17',2,'C',-11,'C',NULL,'mm',NULL,'cm',NULL,NULL,'mm',18,'km/h',270,NULL,'Mostly clear'),(59,4,'2014-02-17','2014-02-18',1,'C',-10,'C',NULL,'mm',NULL,'cm',NULL,NULL,'mm',22,'km/h',270,NULL,'Partly cloudy'),(60,4,'2014-02-17','2014-02-19',-5,'C',-13,'C',NULL,'mm',NULL,'cm',NULL,NULL,'mm',14,'km/h',0,NULL,'Overcast and snow'),(61,4,'2014-02-17','2014-02-20',-9,'C',-16,'C',NULL,'mm',NULL,'cm',NULL,NULL,'mm',14,'km/h',225,NULL,'Partly cloudy'),(62,4,'2014-02-17','2014-02-21',-8,'C',-16,'C',NULL,'mm',NULL,'cm',NULL,NULL,'mm',25,'km/h',0,NULL,'Partly cloudy and light snow'),(63,4,'2014-02-17','2014-02-22',-14,'C',-22,'C',NULL,'mm',NULL,'cm',NULL,NULL,'mm',14,'km/h',0,NULL,'Partly cloudy and light snow'),(64,4,'2014-02-17','2014-02-23',-19,'C',-25,'C',NULL,'mm',NULL,'cm',NULL,NULL,'mm',11,'km/h',0,NULL,'Partly cloudy'),(65,4,'2014-02-17','2014-02-24',-15,'C',-27,'C',NULL,'mm',NULL,'cm',NULL,NULL,'mm',14,'km/h',0,NULL,'Mostly clear'),(66,4,'2014-02-17','2014-02-25',-14,'C',-24,'C',NULL,'mm',NULL,'cm',NULL,NULL,'mm',14,'km/h',270,NULL,'Mostly clear'),(67,4,'2014-02-17','2014-02-26',-12,'C',-22,'C',NULL,'mm',NULL,'cm',NULL,NULL,'mm',14,'km/h',0,NULL,'Mostly clear'),(68,6,'2014-02-17','2014-02-18',-2,'C',-11,'C',NULL,'mm',NULL,'cm',0,NULL,'mm',11,'km/h',248,60,'More sun than clouds. Cool.'),(69,6,'2014-02-17','2014-02-19',-3,'C',-9,'C',NULL,'mm',NULL,'cm',33,NULL,'mm',9,'km/h',158,64,'Decreasing cloudiness. Cool.'),(70,6,'2014-02-17','2014-02-20',-2,'C',-11,'C',NULL,'mm',NULL,'cm',15,NULL,'mm',9,'km/h',248,62,'Mostly cloudy. Cool.'),(71,6,'2014-02-17','2014-02-21',-13,'C',-25,'C',NULL,'mm',NULL,'cm',5,NULL,'mm',10,'km/h',315,61,'Mostly cloudy. Cold.'),(72,6,'2014-02-17','2014-02-22',-11,'C',-27,'C',NULL,'mm',NULL,'cm',15,NULL,'mm',11,'km/h',68,71,'Mostly cloudy. Chilly.'),(73,6,'2014-02-17','2014-02-23',-16,'C',-28,'C',NULL,'mm',NULL,'cm',5,NULL,'mm',4,'km/h',45,74,'Breaks of sun late. Cold.'),(74,6,'2014-02-17','2014-02-24',-11,'C',-20,'C',NULL,'mm',NULL,'cm',0,NULL,'mm',17,'km/h',180,65,'Breaks of sun late. Chilly.'),(75,6,'2014-02-17','2014-02-25',-3,'C',-16,'C',NULL,'mm',NULL,'cm',0,NULL,'mm',9,'km/h',225,68,'More sun than clouds. Chilly.'),(76,6,'2014-02-17','2014-02-26',-1,'C',-9,'C',NULL,'mm',NULL,'cm',0,NULL,'mm',12,'km/h',270,71,'More sun than clouds. Chilly.'),(77,6,'2014-02-17','2014-02-27',-2,'C',-10,'C',NULL,'mm',NULL,'cm',5,NULL,'mm',7,'km/h',180,87,'More clouds than sun. Chilly.'),(78,6,'2014-02-17','2014-02-28',-2,'C',-7,'C',NULL,'mm',NULL,'cm',38,1.15,'cm',4,'km/h',158,87,'Flurries late. Mostly cloudy. Chilly.'),(79,6,'2014-02-17','2014-03-01',-4,'C',-8,'C',NULL,'mm',NULL,'cm',5,NULL,'mm',9,'km/h',90,85,'Broken clouds. Chilly.'),(80,6,'2014-02-17','2014-03-02',-6,'C',-14,'C',NULL,'mm',NULL,'cm',37,3.39,'cm',10,'km/h',293,86,'Flurries late. Mostly cloudy. Chilly.'),(81,6,'2014-02-17','2014-03-03',-11,'C',-19,'C',NULL,'mm',NULL,'cm',15,NULL,'mm',10,'km/h',338,83,'Mostly cloudy. Cold.'),(82,6,'2014-02-17','2014-03-04',-14,'C',-26,'C',NULL,'mm',NULL,'cm',15,NULL,'mm',9,'km/h',90,85,'Mostly cloudy. Cold.'),(83,3,'2014-02-17','2014-02-17',0,'C',-11,'C',NULL,'mm',NULL,'cm',NULL,NULL,'mm',NULL,NULL,NULL,NULL,'weather forecast for Monday is Mostly Cloudy'),(84,3,'2014-02-17','2014-02-18',-1,'C',-6,'C',NULL,'mm',NULL,'cm',NULL,NULL,'mm',NULL,NULL,NULL,NULL,'weather forecast for Tuesday is Partially cloudy'),(85,3,'2014-02-17','2014-02-19',-6,'C',-15,'C',NULL,'mm',NULL,'cm',NULL,NULL,'mm',NULL,NULL,NULL,NULL,'weather forecast for Wednesday is Snow Showers'),(86,3,'2014-02-17','2014-02-20',-7,'C',-18,'C',NULL,'mm',NULL,'cm',NULL,NULL,'mm',NULL,NULL,NULL,NULL,'weather forecast for Thursday is Cloudy'),(87,3,'2014-02-17','2014-02-21',-15,'C',-19,'C',NULL,'mm',NULL,'cm',NULL,NULL,'mm',NULL,NULL,NULL,NULL,'weather forecast for Friday is Snow Showers'),(88,9,'2014-02-17','2014-02-17',0,'C',-17,'C',NULL,'mm',NULL,'cm',NULL,NULL,'mm',25,'km/h',90,NULL,'cloudy with little or no clear sky'),(89,9,'2014-02-17','2014-02-18',-2,'C',-20,'C',NULL,'mm',NULL,'cm',NULL,NULL,'mm',23,'km/h',135,NULL,'clear with low and high clouds'),(90,9,'2014-02-17','2014-02-19',-3,'C',-7,'C',NULL,'mm',NULL,'cm',NULL,NULL,'mm',21,'km/h',0,NULL,'cloudy with light snow'),(91,9,'2014-02-17','2014-02-20',-7,'C',-16,'C',NULL,'mm',NULL,'cm',NULL,NULL,'mm',13,'km/h',0,NULL,'cloudy with little or no clear sky'),(92,9,'2014-02-17','2014-02-21',-13,'C',-17,'C',NULL,'mm',NULL,'cm',NULL,NULL,'mm',12,'km/h',45,NULL,'clear with low and high clouds'),(93,9,'2014-02-17','2014-02-22',-12,'C',-19,'C',NULL,'mm',NULL,'cm',NULL,NULL,'mm',8,'km/h',45,NULL,'clear with low and high clouds'),(94,9,'2014-02-17','2014-02-23',-1,'C',-11,'C',NULL,'mm',NULL,'cm',NULL,NULL,'mm',12,'km/h',90,NULL,'cloudy with little or no clear sky'),(95,9,'2014-02-17','2014-02-24',1,'C',-5,'C',NULL,'mm',NULL,'cm',NULL,NULL,'mm',12,'km/h',90,NULL,'clear with low and high clouds'),(96,9,'2014-02-17','2014-02-25',2,'C',-5,'C',NULL,'mm',NULL,'cm',NULL,NULL,'mm',6,'km/h',135,NULL,'cloudy with no clear sky'),(97,9,'2014-02-17','2014-02-26',2,'C',-4,'C',NULL,'mm',NULL,'cm',NULL,NULL,'mm',5,'km/h',180,NULL,'clear with low and high clouds'),(98,9,'2014-02-17','2014-02-27',2,'C',-5,'C',NULL,'mm',NULL,'cm',NULL,NULL,'mm',9,'km/h',270,NULL,'clear with low and high clouds'),(99,9,'2014-02-17','2014-02-28',2,'C',-5,'C',NULL,'mm',NULL,'cm',NULL,NULL,'mm',8,'km/h',90,NULL,'clear with low and high clouds'),(100,9,'2014-02-17','2014-03-01',1,'C',-6,'C',NULL,'mm',NULL,'cm',NULL,NULL,'mm',5,'km/h',135,NULL,'cloudy with little or no clear sky'),(101,9,'2014-02-17','2014-03-02',1,'C',-6,'C',NULL,'mm',NULL,'cm',NULL,NULL,'mm',7,'km/h',45,NULL,'cloudy with little or no clear sky');
/*!40000 ALTER TABLE `weather_forecast` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `weather_real`
--

DROP TABLE IF EXISTS `weather_real`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `weather_real` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` tinyint(3) unsigned NOT NULL,
  `date` date DEFAULT NULL,
  `high` decimal(3,1) DEFAULT NULL,
  `high_unit` char(1) NOT NULL DEFAULT 'C',
  `low` decimal(3,1) DEFAULT NULL,
  `low_unit` char(1) NOT NULL DEFAULT 'C',
  `rain` decimal(3,1) DEFAULT NULL,
  `rain_unit` varchar(2) DEFAULT 'mm',
  `snow` decimal(3,1) DEFAULT NULL,
  `snow_unit` varchar(2) DEFAULT 'cm',
  `precip` decimal(5,2) DEFAULT NULL,
  `precip_unit` char(2) NOT NULL DEFAULT 'mm',
  `cloud_cover` tinyint(3) unsigned DEFAULT NULL,
  `wind_speed` tinyint(3) unsigned DEFAULT NULL,
  `wind_unit` varchar(4) DEFAULT 'km/h',
  `wind_direction` smallint(5) unsigned DEFAULT NULL,
  `pressure` decimal(5,2) DEFAULT NULL,
  `pressure_unit` varchar(4) DEFAULT 'kPa',
  `pressure_coefficient` decimal(5,3) DEFAULT NULL,
  `humidity` tinyint(3) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `site_id` (`site_id`,`date`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `weather_real`
--

LOCK TABLES `weather_real` WRITE;
/*!40000 ALTER TABLE `weather_real` DISABLE KEYS */;
INSERT INTO `weather_real` VALUES (1,8,'2014-02-16',-2.9,'C',-9.7,'C',0.0,'mm',NULL,'cm',NULL,'mm',NULL,3,'m/s',355,99.22,'kPa',0.031,77),(2,2,'2014-02-16',-4.9,'C',-10.6,'C',NULL,'mm',NULL,'cm',0.00,'mm',35,10,'km/h',346,91.33,'kPa',0.042,63),(3,1,'2014-02-16',-5.9,'C',-11.5,'C',0.0,'mm',0.0,'cm',0.00,'mm',35,15,'km/h',352,90.87,'kPa',0.033,82);
/*!40000 ALTER TABLE `weather_real` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `weather_site`
--

DROP TABLE IF EXISTS `weather_site`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `weather_site` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `site_name` varchar(200) DEFAULT NULL,
  `site_url` varchar(250) DEFAULT NULL,
  `notes` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `weather_site`
--

LOCK TABLES `weather_site` WRITE;
/*!40000 ALTER TABLE `weather_site` DISABLE KEYS */;
INSERT INTO `weather_site` VALUES (1,'Edmonton International Airport','http://climate.weather.gc.ca/climateData/dailydata_e.html?StationID=50149&Year=2014&Month=1','Note StationID; modify GET parameters for month'),(2,'Edmonton City Centre AWOS','http://climate.weather.gc.ca/climateData/dailydata_e.html?StationID=31427&Year=2014&Month=1','Sometimes misses data, but note StationID and modify GET parameters for month'),(3,'OpenWeather.com (6-day)','http://www.weatherforecastmap.com/canada/edmonton','Andrea and Christina'),(4,'Foreca (10-day)','http://www.foreca.com/Canada/Edmonton?tenday','Aiden and John'),(5,'CBC (6-day)','http://www.cbc.ca/edmonton/weather/s0000045.html','Michael and Zach'),(6,'MyForecast (15-day)','http://www.myforecast.com/bin/expanded_forecast_15day.m?city=54149&metric=true','Sonja'),(7,'AccuWeather (45-day)','http://www.accuweather.com/en/ca/edmonton/t5k/daily-weather-forecast/52478','hq; uses \'precip\' instead of \'rain\''),(8,'Tory Building Weather Station','http://easweb.eas.ualberta.ca/weather_archive.php','hq; real weather data but has only temps, pressure and humidity'),(9,'Weather-in-Canada.com (14-day)','http://www.weather-in-canada.com/Alberta/Weather_in_Edmonton/14-day-forecast','hq; wind direction uses \'V\' for \'W\' (I think)'),(10,'Weather Underground','http://www.wunderground.com/global/stations/71123.html','Dan'),(11,'Environment Canada City Centre','http://weather.gc.ca/city/pages/ab-50_metric_e.html','Brett'),(12,'Environment Canada International','http://weather.gc.ca/city/pages/ab-71_metric_e.html','Extended Brett\'s class'),(13,'Zoover UK (14-day)','http://www.zoover.co.uk/canada/alberta/edmonton/weather','Christina (just for fun!)');
/*!40000 ALTER TABLE `weather_site` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-02-17 20:29:58
