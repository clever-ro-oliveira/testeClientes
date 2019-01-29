-- --------------------------------------------------------
-- Servidor:                     127.0.0.1
-- Versão do servidor:           10.1.29-MariaDB - mariadb.org binary distribution
-- OS do Servidor:               Win32
-- HeidiSQL Versão:              9.5.0.5196
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Copiando estrutura do banco de dados para clientes
CREATE DATABASE IF NOT EXISTS `clientes` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `clientes`;

-- Copiando estrutura para tabela clientes.clientes
DROP TABLE IF EXISTS `clientes`;
CREATE TABLE IF NOT EXISTS `clientes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cpf` bigint(11) unsigned zerofill DEFAULT NULL,
  `data_nasc` date DEFAULT NULL,
  `nome` varchar(255) DEFAULT NULL,
  `sobrenome` varchar(15) DEFAULT NULL,
  `cep` int(8) unsigned zerofill DEFAULT NULL,
  `endereco` varchar(255) DEFAULT NULL,
  `numero` varchar(255) DEFAULT NULL,
  `bairro` varchar(255) DEFAULT NULL,
  `cidade` varchar(255) DEFAULT NULL,
  `estado` varchar(255) DEFAULT NULL,
  `complemento` varchar(255) DEFAULT NULL,
  `cnpj` bigint(14) unsigned zerofill DEFAULT NULL,
  `razao` varchar(50) DEFAULT NULL,
  `nome_fantasia` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Copiando dados para a tabela clientes.clientes: ~2 rows (aproximadamente)
DELETE FROM `clientes`;
/*!40000 ALTER TABLE `clientes` DISABLE KEYS */;
INSERT INTO `clientes` (`id`, `cpf`, `data_nasc`, `nome`, `sobrenome`, `cep`, `endereco`, `numero`, `bairro`, `cidade`, `estado`, `complemento`, `cnpj`, `razao`, `nome_fantasia`) VALUES
	(1, 19042363835, '1977-03-16', 'Cleverson', 'de Oliveira', 13478710, 'Rua &Acirc;ngelo Ortolan', '150', 'Loteamento Industrial Machadinho', 'Americana', 'SP', 'Bl 48 Apto 101', 00000000000000, '', ''),
	(2, 00000000000, '0000-00-00', '', '', 01001010, 'Rua Filipe de Oliveira', '48', 'S&eacute;', 'S&atilde;o Paulo', 'SP', '', 70202007000171, 'Teste Formul&aacute;rio Ltda', 'Teste Formul&aacute;rio');
/*!40000 ALTER TABLE `clientes` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
