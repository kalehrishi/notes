
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
alter table Sessions modify isExpired TINYINT(1) NOT NULL DEFAULT 0;

 