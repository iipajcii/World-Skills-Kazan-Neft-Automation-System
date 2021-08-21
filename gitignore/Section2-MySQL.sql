-- MySQL dump 10.13  Distrib 8.0.14, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: session4
-- ------------------------------------------------------
-- Server version	8.0.14

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
 SET NAMES utf8 ;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `orderitems`
--

DROP TABLE IF EXISTS `orderitems`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `orderitems` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `OrderID` bigint(20) NOT NULL,
  `PartID` bigint(20) NOT NULL,
  `BatchNumber` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `Amount` decimal(18,2) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `FK_Transactions_Parts` (`PartID`),
  KEY `FK_OrderItems_Orders` (`OrderID`),
  CONSTRAINT `FK_OrderItems_Orders` FOREIGN KEY (`OrderID`) REFERENCES `orders` (`ID`),
  CONSTRAINT `FK_Transactions_Parts` FOREIGN KEY (`PartID`) REFERENCES `parts` (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=137 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orderitems`
--

LOCK TABLES `orderitems` WRITE;
/*!40000 ALTER TABLE `orderitems` DISABLE KEYS */;
INSERT INTO `orderitems` VALUES (1,1,8,'',2.00),(2,1,6,'SL1258',2.00),(3,1,1,'',4.00),(5,1,10,'TR740LKO',1.00),(6,1,12,'',2.00),(7,2,4,'XP985S',4.00),(9,2,7,'',5.00),(10,2,3,'',10.00),(11,2,8,'',2.00),(12,3,4,'XM471W',2.00),(13,3,5,'',5.00),(14,3,1,'',4.00),(16,3,2,'',5.00),(17,4,8,'',2.00),(19,4,3,'',5.00),(20,5,10,'TB44705KO',3.00),(21,5,12,'',1.00),(22,5,6,'KL4701',5.00),(23,5,7,'',3.00),(25,5,11,'',5.00),(26,6,8,'',1.00),(27,6,2,'',7.00),(29,6,12,'',1.00),(30,6,4,'XP985S',4.00),(31,7,11,'',5.00),(32,7,6,'KL4701',4.00),(33,7,3,'',5.00),(36,8,3,'',5.00),(37,8,8,'',2.00),(38,9,9,'',3.00),(39,9,6,'KL4701',3.00),(41,9,11,'',3.00),(42,10,12,'',4.00),(43,10,8,'',5.00),(44,11,7,'',4.00),(45,11,1,'',4.00),(46,11,2,'',5.00),(47,11,10,'TJ140OO',3.00),(48,12,6,'KL4701',5.00),(49,12,11,'',5.00),(50,12,3,'',1.00),(51,12,9,'',3.00),(52,13,4,'XM471W',5.00),(53,14,5,'',4.00),(54,14,11,'',5.00),(55,14,12,'',5.00),(56,15,4,'XM471W',1.00),(57,15,8,'',2.00),(58,15,6,'KO4570',5.00),(60,16,8,'',1.00),(61,16,12,'',3.00),(62,16,10,'TJ140OO',1.00),(63,16,7,'',3.00),(64,17,7,'',3.00),(65,17,9,'',1.00),(67,18,1,'',2.00),(68,18,5,'',1.00),(69,18,4,'XM471W',3.00),(72,19,4,'XM471W',5.00),(73,19,1,'',1.00),(74,20,4,'XM471W',3.00),(75,20,7,'',1.00),(77,21,1,'',5.00),(78,21,8,'',2.00),(79,21,6,'KO4570',4.00),(80,22,9,'',4.00),(81,22,11,'',4.00),(82,22,5,'',2.00),(83,23,3,'',4.00),(84,23,5,'',1.00),(85,23,6,'SL1258',1.00),(86,23,10,'TJ140OO',4.00),(87,24,2,'',3.00),(88,24,1,'',3.00),(89,24,11,'',5.00),(91,25,8,'',4.00),(93,25,11,'',1.00),(95,26,5,'',3.00),(96,26,9,'',5.00),(97,27,7,'',2.00),(98,27,2,'',5.00),(99,28,11,'',5.00),(100,28,3,'',2.00),(101,28,4,'XP985S',3.00),(102,29,1,'',4.00),(104,29,2,'',3.00),(105,29,5,'',5.00),(106,29,4,'XP985S',3.00),(107,30,11,'',3.00),(108,30,6,'SL1258',1.00),(110,31,10,'TR740LKO',1.00),(112,31,12,'',1.00),(113,32,11,'',3.00),(114,32,10,'TJ140OO',1.00),(115,32,12,'',1.00),(116,33,8,'',3.00),(118,33,7,'',2.00),(119,34,8,'',2.00),(120,34,9,'',16.00),(122,34,7,'',1.00),(123,35,10,'TB44705KO',3.00),(124,35,1,'',4.00),(125,35,3,'',5.00),(126,35,5,'',4.00),(127,36,7,'',5.00),(128,36,2,'',3.00),(129,37,8,'',1.00),(130,37,11,'',2.00),(131,37,4,'XM471W',2.00),(132,37,2,'',4.00),(133,37,1,'',3.00),(134,37,3,'',4.00),(135,37,7,'',5.00),(136,37,7,'',4.00);
/*!40000 ALTER TABLE `orderitems` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `orders` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `TransactionTypeID` bigint(20) NOT NULL,
  `SupplierID` bigint(20) DEFAULT NULL,
  `SourceWarehouseID` bigint(20) DEFAULT NULL,
  `DestinationWarehouseID` bigint(20) DEFAULT NULL,
  `Date` date NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `FK_Headers_Suppliers` (`SupplierID`),
  KEY `FK_Headers_Stocks` (`SourceWarehouseID`),
  KEY `FK_Headers_Stocks1` (`DestinationWarehouseID`),
  KEY `FK_Headers_TransactionTypes` (`TransactionTypeID`),
  CONSTRAINT `FK_Headers_Stocks` FOREIGN KEY (`SourceWarehouseID`) REFERENCES `warehouses` (`ID`),
  CONSTRAINT `FK_Headers_Stocks1` FOREIGN KEY (`DestinationWarehouseID`) REFERENCES `warehouses` (`ID`),
  CONSTRAINT `FK_Headers_Suppliers` FOREIGN KEY (`SupplierID`) REFERENCES `suppliers` (`ID`),
  CONSTRAINT `FK_Headers_TransactionTypes` FOREIGN KEY (`TransactionTypeID`) REFERENCES `transactiontypes` (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (1,1,3,NULL,2,'2019-08-18'),(2,1,4,NULL,1,'2019-08-18'),(3,1,4,NULL,1,'2019-08-18'),(4,1,3,NULL,2,'2019-08-18'),(5,1,3,NULL,2,'2019-08-18'),(6,1,2,NULL,2,'2019-08-18'),(7,1,3,NULL,1,'2019-08-18'),(8,1,2,NULL,1,'2019-08-22'),(9,1,3,NULL,2,'2019-08-22'),(10,1,4,NULL,2,'2019-08-22'),(11,1,3,NULL,1,'2019-08-23'),(12,1,4,NULL,2,'2019-08-23'),(13,1,2,NULL,2,'2019-08-23'),(14,1,3,NULL,2,'2019-08-23'),(15,1,2,NULL,2,'2019-08-23'),(16,1,3,NULL,2,'2019-08-23'),(17,1,4,NULL,2,'2019-08-23'),(18,1,1,NULL,2,'2019-08-23'),(19,1,1,NULL,2,'2019-08-24'),(20,1,2,NULL,2,'2019-08-24'),(21,1,2,NULL,2,'2019-08-24'),(22,1,4,NULL,2,'2019-08-24'),(23,1,1,NULL,2,'2019-08-24'),(24,1,3,NULL,2,'2019-08-24'),(25,1,3,NULL,1,'2019-08-24'),(26,1,2,NULL,2,'2019-08-24'),(27,2,NULL,1,2,'2019-08-18'),(28,2,NULL,1,2,'2019-08-19'),(29,2,NULL,2,1,'2019-08-19'),(30,2,NULL,2,1,'2019-08-19'),(31,2,NULL,2,1,'2019-08-20'),(32,2,NULL,1,2,'2019-08-23'),(33,2,NULL,1,2,'2019-08-20'),(34,2,NULL,2,1,'2019-08-22'),(35,2,NULL,2,1,'2019-08-22'),(36,2,NULL,1,2,'2019-08-24'),(37,2,NULL,2,1,'2019-08-24');
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `parts`
--

DROP TABLE IF EXISTS `parts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `parts` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Name` varchar(50) COLLATE utf8_bin NOT NULL,
  `EffectiveLife` bigint(20) DEFAULT NULL,
  `BatchNumberHasRequired` tinyint(1) DEFAULT NULL,
  `MinimumAmount` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `parts`
--

LOCK TABLES `parts` WRITE;
/*!40000 ALTER TABLE `parts` DISABLE KEYS */;
INSERT INTO `parts` VALUES (1,'BLUE STORM Battery 12V 45Ah 54459',650,0,10),(2,'BLUE STORM Battery 12V 70Ah 80D26L',700,0,10),(3,'CT20 Turbo Turbocharger',NULL,0,0),(4,'michelin tyres   225/50 ZR 16',1000,1,6),(5,'MOCA Engine Timing Chain Kit ',NULL,0,0),(6,'CT16V Turbo Cartridge Core',NULL,1,0),(7,'iFJF 21100-35520 New Carburetor',NULL,0,0),(8,'ALAVENTE 21100-35463 Carburetor ',NULL,0,0),(9,'Carter P4594 In-Line Electric Fuel Pump',NULL,0,0),(10,'Electric Fuel Pump Universal Fuel Pump 12V ',NULL,1,0),(11,'Gast AT05 Rotary Vane ',NULL,0,0),(12,'FAN 24\" M480',200,0,50);
/*!40000 ALTER TABLE `parts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `suppliers`
--

DROP TABLE IF EXISTS `suppliers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `suppliers` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Name` varchar(50) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `suppliers`
--

LOCK TABLES `suppliers` WRITE;
/*!40000 ALTER TABLE `suppliers` DISABLE KEYS */;
INSERT INTO `suppliers` VALUES (1,'MJOK petroleum'),(2,'Kazan Bosch  Center'),(3,'Denso Corp'),(4,'Castrol Crop');
/*!40000 ALTER TABLE `suppliers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transactiontypes`
--

DROP TABLE IF EXISTS `transactiontypes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `transactiontypes` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Name` varchar(50) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transactiontypes`
--

LOCK TABLES `transactiontypes` WRITE;
/*!40000 ALTER TABLE `transactiontypes` DISABLE KEYS */;
INSERT INTO `transactiontypes` VALUES (1,'Purchase Order'),(2,'Warehouse Management');
/*!40000 ALTER TABLE `transactiontypes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `warehouses`
--

DROP TABLE IF EXISTS `warehouses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `warehouses` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Name` varchar(50) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `warehouses`
--

LOCK TABLES `warehouses` WRITE;
/*!40000 ALTER TABLE `warehouses` DISABLE KEYS */;
INSERT INTO `warehouses` VALUES (1,'Central Warehouse'),(2,'Volka  Warehouse');
/*!40000 ALTER TABLE `warehouses` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-08-24 14:33:32
