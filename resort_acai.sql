-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 07-Maio-2026 às 20:54
-- Versão do servidor: 5.7.17
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `resort_acai`
--
DROP DATABASE IF EXISTS `resort_acai`;
CREATE DATABASE IF NOT EXISTS `resort_acai` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `resort_acai`;

-- --------------------------------------------------------

--
-- Estrutura da tabela `administrador`
--

CREATE TABLE `administrador` (
  `cod_adm` int(11) NOT NULL,
  `nome` varchar(30) DEFAULT NULL,
  `login` varchar(20) DEFAULT NULL,
  `senha` varchar(70) DEFAULT NULL,
  `nivel` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `administrador`
--

INSERT INTO `administrador` (`cod_adm`, `nome`, `login`, `senha`, `nivel`) VALUES
(1, 'Genésio da Silva', 'admin', '$2y$10$9AwOx2dqd2p8mG/XQp9dGOkwGjsmNMd76eBr8i4rq9EQPlVu20KG.', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `hospede`
--

CREATE TABLE `hospede` (
  `nome` varchar(30) DEFAULT NULL,
  `telefone` varchar(14) DEFAULT NULL,
  `cpf` bigint(20) NOT NULL,
  `cidade` varchar(30) DEFAULT NULL,
  `endereco` varchar(70) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `parceiros`
--

CREATE TABLE `parceiros` (
  `cnpj` bigint(20) NOT NULL,
  `nome` varchar(50) DEFAULT NULL,
  `logo` blob,
  `telefone` varchar(14) DEFAULT NULL,
  `descricao` text,
  `cod_adm` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `quarto`
--

CREATE TABLE `quarto` (
  `numero` int(11) NOT NULL,
  `cama` int(11) DEFAULT NULL,
  `nivel` int(11) DEFAULT NULL,
  `descricao` text,
  `status` tinyint(4) DEFAULT NULL,
  `foto` longblob,
  `valor` decimal(7,2) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `reserva`
--

CREATE TABLE `reserva` (
  `cod_res` int(11) NOT NULL,
  `total` decimal(8,2) DEFAULT NULL,
  `data_ent` date DEFAULT NULL,
  `data_sai` date DEFAULT NULL,
  `cpf` bigint(20) DEFAULT NULL,
  `quarto` int(11) DEFAULT NULL,
  `cod_adm` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `administrador`
--
ALTER TABLE `administrador`
  ADD PRIMARY KEY (`cod_adm`);

--
-- Indexes for table `hospede`
--
ALTER TABLE `hospede`
  ADD PRIMARY KEY (`cpf`);

--
-- Indexes for table `parceiros`
--
ALTER TABLE `parceiros`
  ADD PRIMARY KEY (`cnpj`),
  ADD KEY `cod_adm` (`cod_adm`);

--
-- Indexes for table `quarto`
--
ALTER TABLE `quarto`
  ADD PRIMARY KEY (`numero`);

--
-- Indexes for table `reserva`
--
ALTER TABLE `reserva`
  ADD PRIMARY KEY (`cod_res`),
  ADD KEY `cpf` (`cpf`),
  ADD KEY `numero` (`quarto`),
  ADD KEY `cod_adm` (`cod_adm`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `administrador`
--
ALTER TABLE `administrador`
  MODIFY `cod_adm` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `reserva`
--
ALTER TABLE `reserva`
  MODIFY `cod_res` int(11) NOT NULL AUTO_INCREMENT;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
