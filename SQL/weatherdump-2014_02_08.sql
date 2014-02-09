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
  `precip_amount` decimal(4,1) DEFAULT NULL,
  `precip_unit` char(2) DEFAULT 'mm',
  `wind_speed` tinyint(3) unsigned DEFAULT NULL,
  `wind_unit` varchar(4) DEFAULT 'km/h',
  `wind_direction` smallint(5) unsigned DEFAULT NULL,
  `prose_forecast` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `weather_forecast`
--

LOCK TABLES `weather_forecast` WRITE;
/*!40000 ALTER TABLE `weather_forecast` DISABLE KEYS */;
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
  `precip` decimal(4,1) DEFAULT NULL,
  `precip_unit` char(2) NOT NULL DEFAULT 'mm',
  `cloud_cover` tinyint(3) unsigned DEFAULT NULL,
  `wind_speed` tinyint(3) unsigned DEFAULT NULL,
  `wind_unit` varchar(4) DEFAULT 'km/h',
  `wind_direction` smallint(5) unsigned DEFAULT NULL,
  `pressure` decimal(5,2) DEFAULT NULL,
  `humidity` tinyint(3) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `site_id` (`site_id`,`date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `weather_real`
--

LOCK TABLES `weather_real` WRITE;
/*!40000 ALTER TABLE `weather_real` DISABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `weather_site`
--

LOCK TABLES `weather_site` WRITE;
/*!40000 ALTER TABLE `weather_site` DISABLE KEYS */;
INSERT INTO `weather_site` VALUES (1,'Edmonton International Airport','http://climate.weather.gc.ca/climateData/dailydata_e.html?StationID=50149&Year=2014&Month=1','Note StationID; modify GET parameters for month'),(2,'Edmonton City Centre AWOS','http://climate.weather.gc.ca/climateData/dailydata_e.html?StationID=31427&Year=2014&Month=1','Sometimes misses data, but note StationID and modify GET parameters for month'),(3,'OpenWeather.com (6-day)','http://www.weatherforecastmap.com/canada/edmonton',NULL),(4,'Foreca (10-day)','http://www.foreca.com/Canada/Edmonton?tenday',NULL),(5,'CBC (6-day)','http://www.cbc.ca/edmonton/weather/s0000045.html',NULL),(6,'MyForecast (15-day)','http://www.myforecast.com/bin/expanded_forecast_15day.m?city=54149&metric=true',NULL),(7,'AccuWeather (45-day)','http://www.accuweather.com/en/ca/edmonton/t5k/daily-weather-forecast/52478','Uses \'precip\' instead of \'rain\''),(8,'Tory Building Weather Station','http://easweb.eas.ualberta.ca/weather_archive.php','Has only temps, pressure and humidity'),(9,'Weather-in-Canada.com (14-day)','http://www.weather-in-canada.com/Alberta/Weather_in_Edmonton/14-day-forecast','Wind direction uses \"V\" for \"W\" (I think)');
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

-- Dump completed on 2014-02-08 18:36:51
