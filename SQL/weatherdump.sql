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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `weather_site`
--

LOCK TABLES `weather_site` WRITE;
/*!40000 ALTER TABLE `weather_site` DISABLE KEYS */;
INSERT INTO `weather_site` VALUES (1,'Edmonton International Airport','http://climate.weather.gc.ca/climateData/dailydata_e.html?StationID=50149&Year=2014&Month=1','Note StationID; modify GET parameters for month'),(2,'Edmonton City Centre AWOS','http://climate.weather.gc.ca/climateData/dailydata_e.html?StationID=31427&Year=2014&Month=1','Sometimes misses data, but note StationID and modify GET parameters for month'),(3,'OpenWeather.com (6-day)','http://www.weatherforecastmap.com/canada/edmonton',NULL),(4,'Foreca (10-day)','http://www.foreca.com/Canada/Edmonton?tenday',NULL),(5,'CBC (6-day)','http://www.cbc.ca/edmonton/weather/s0000045.html',NULL),(6,'MyForecast (15-day)','http://www.myforecast.com/bin/expanded_forecast_15day.m?city=54149&metric=true',NULL),(7,'AccuWeather (45-day)','http://www.accuweather.com/en/ca/edmonton/t5k/daily-weather-forecast/52478','Uses \'precip\' instead of \'rain\'');
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

-- Dump completed on 2014-02-02 10:29:02
