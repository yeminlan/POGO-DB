delimiter $$

CREATE TABLE `taxonomy` (
  `idSpecies` int(11) NOT NULL AUTO_INCREMENT,
  `Genome` varchar(256) DEFAULT NULL,
  `Phylum` varchar(256) DEFAULT NULL,
  `Class` varchar(256) DEFAULT NULL,
  `Order` varchar(256) DEFAULT NULL,
  `Family` varchar(256) DEFAULT NULL,
  `Genus` varchar(256) DEFAULT NULL,
  `Species` varchar(256) DEFAULT NULL,
  PRIMARY KEY (`idSpecies`)
) ENGINE=InnoDB DEFAULT CHARSET=big5$$
