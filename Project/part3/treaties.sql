-- MySQL dump 10.13  Distrib 5.5.43, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: countriesAndIntlAffairs
-- ------------------------------------------------------
-- Server version	5.5.43-0ubuntu0.14.04.1-log

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
-- Table structure for table `Treaties`
--

DROP TABLE IF EXISTS `Treaties`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Treaties` (
  `treatyNumber` varchar(8) NOT NULL DEFAULT '',
  `name` varchar(255) NOT NULL,
  `dateEnforced` varchar(8) NOT NULL,
  `description` varchar(255) NOT NULL,
  `wikipage` varchar(255) NOT NULL,
  PRIMARY KEY (`treatyNumber`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Treaties`
--

LOCK TABLES `Treaties` WRITE;
/*!40000 ALTER TABLE `Treaties` DISABLE KEYS */;
INSERT INTO `Treaties` VALUES ('ICRC0001','Geneva Conventions','19490812','The Geneva Conventions comprise four treaties, and three additional protocols, that establish the standards of international law for the humanitarian treatment of war','https://en.wikipedia.org/wiki/Geneva_Conventions'),('UNA30822','Kyoto Protocol','20050216','Kyoto Protocol to the United Nations Framework Convention on Climate Change','https://en.wikipedia.org/wiki/List_of_parties_to_the_Kyoto_Protocol'),('UNI01021','Genocide Convention','19510112','Prevention and Punishment of the Crime of Genocide (CPPCG)','https://en.wikipedia.org/wiki/Genocide_Convention'),('UNI10485','Non-Proliferation of Nuclear Weapons','19700305','Treaty on the Non-Proliferation of Nuclear Weapons','https://en.wikipedia.org/wiki/List_of_parties_to_the_Treaty_on_the_Non-Proliferation_of_Nuclear_Weapons'),('UNI14860','Biological Weapons Convention','19750326','Convention on the prohibition of the development, production and stockpiling of bacteriological (biological) and toxin weapons and on their destruction','https://en.wikipedia.org/wiki/List_of_parties_to_the_Biological_Weapons_Convention'),('UNI20378','Elimination of Discrimination against Women','19810903','Convention on the Elimination of All Forms of Discrimination against Women','https://en.wikipedia.org/wiki/List_of_parties_to_the_Convention_on_the_Elimination_of_All_Forms_of_Discrimination_Against_Women'),('UNI30822','Framework Convention on Climate Change','19940321','United Nations Framework Convention on Climate Change','https://en.wikipedia.org/wiki/List_of_parties_to_the_United_Nations_Framework_Convention_on_Climate_Change'),('UNI31363','Law of the Sea','19941116','United Nations Convention on the Law of the Sea','https://en.wikipedia.org/wiki/List_of_parties_to_the_United_Nations_Convention_on_the_Law_of_the_Sea'),('UNI33757','Chemical Weapons Convention','19970429','Convention on the Prohibition of the Development, Production, Stockpiling and Use of Chemical Weapons and on their Destruction','https://en.wikipedia.org/wiki/List_of_parties_to_the_Chemical_Weapons_Convention'),('UNI35597','Ottawa Treaty','19990301','Prohibition of the Use, Stockpiling, Production and Transfer of Anti-Personnel Mines and on their Destruction','https://en.wikipedia.org/wiki/List_of_parties_to_the_Ottawa_Treaty'),('UNI38544','Rome Statute','20020701','Rome Statute of the International Criminal Court','https://en.wikipedia.org/wiki/States_parties_to_the_Rome_Statute_of_the_International_Criminal_Court');
/*!40000 ALTER TABLE `Treaties` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-04-02 12:25:06
