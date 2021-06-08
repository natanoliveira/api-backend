# ************************************************************
# Sequel Pro SQL dump
# Versão 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.5.5-10.4.8-MariaDB)
# Base de Dados: pushstart
# Tempo de Geração: 2021-06-08 01:09:23 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump da tabela sessao
# ------------------------------------------------------------

DROP TABLE IF EXISTS `sessao`;

CREATE TABLE `sessao` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `sessao_id` varchar(100) DEFAULT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `tempo_inicial` bigint(20) DEFAULT NULL,
  `data_acesso` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



# Dump da tabela usuario
# ------------------------------------------------------------

DROP TABLE IF EXISTS `usuario`;

CREATE TABLE `usuario` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) DEFAULT NULL,
  `nome_perfil` varchar(30) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `senha` text DEFAULT NULL,
  `ultimo_acesso` datetime DEFAULT NULL,
  `cadastro` datetime DEFAULT current_timestamp(),
  `atualizacao` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `token` varchar(100) DEFAULT NULL,
  `avatar` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;

INSERT INTO `usuario` (`id`, `nome`, `nome_perfil`, `email`, `senha`, `ultimo_acesso`, `cadastro`, `atualizacao`, `token`, `avatar`)
VALUES
	(1,'ESTER SOARES DE OLIVEIRA SOUSA','ESTER SOUSA','ester1403@gmail.com','$2y$10$l/gj1BATaH.7cHrJT6wTHuHiWMpmJsmrZLQ.6t15RlMv4RX4DmvHa',NULL,'2021-06-07 16:33:27',NULL,'0FD820C7-A5BE-131D-39A6-0027F5B863B0',NULL),
	(2,'NATAN DE OLIVEIRA SOUSA','NATAN SOUSA','natanoliveirati@gmail.com','$2y$10$5IF3Jq7ArajPEa9wmoYjbOA2XWW/eZy//syuwnC2tKVGvaI7SXKjm',NULL,'2021-06-07 16:35:39','2021-06-07 20:35:02','C38F8A88-F6CA-D5B8-95DF-5DF6D6DF2307','http://localhost/desafio-pushstart/api-backend/upload/581c523a1d28872824c63b028d4ff470081f9ea6.jpg'),
	(3,'FRANCISCO DE FATIMA CARDOSO SOUSA','FRANCISCO SOUSA','fcardoso0955@gmail.com','$2y$10$A5nOd2i4gWuydEw6O6hKO.CNMdDt/4hpBuC8xcvXoo.SLv9UivCkK',NULL,'2021-06-07 16:36:36',NULL,'EC54ABEA-0FF5-7588-CD5B-511A89D6D82A',NULL),
	(4,'ELOY KALEL ABREU DE OLIVEIRA','ELOY OLIVEIRA','eloykalel@gmail.com','$2y$10$lty.iRZTYoAad4fUfOY66.LKq88AWA1HUWiBfjUB0j9p.RgSMDZgG',NULL,'2021-06-07 16:37:00','2021-06-07 19:31:36','71F22628-9C7B-FBB1-4508-45FB579A0F7E','http://localhost/desafio-pushstart/api-backend/upload/2af9ce0b16a5f83d67fc89c6faa1aea81247c463.jpg'),
	(5,'NATÁLIA DE OLIVEIRA SOUSA','NATÁLIA SOUSA','natallie.oliveira.sousa@gmail.com','$2y$10$UftO6MGFHv03qsrAa54juu.v7cO6IRRYRNMmw5hGYWFfvoYIAjDBO',NULL,'2021-06-07 16:37:35',NULL,'B784C83B-FE97-2FAD-45F8-41FF6C7C5D5D',NULL),
	(6,'CARLOS CESAR','CARLOS CESAR','carloscesar@gmail.com','$2y$10$kHDZY8Ssw1Y41j56A/eU3uhlavda2I.9GntR/NnhZuW/UulUXsNaW','2021-06-07 20:44:24','2021-06-07 19:35:27','2021-06-07 20:44:24','40AE2DA6-7731-F742-7F8E-8D2062203D65',NULL);

/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
