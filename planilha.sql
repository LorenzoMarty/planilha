-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 09/01/2025 às 01:42
-- Versão do servidor: 8.3.0
-- Versão do PHP: 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `planilha`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `produto`
--

DROP TABLE IF EXISTS `produto`;
CREATE TABLE IF NOT EXISTS `produto` (
  `id_produto` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `valor_custo` float NOT NULL,
  `valor_venda` float NOT NULL,
  `qntdC` int NOT NULL,
  `ponto_equilibrio` time DEFAULT NULL,
  `valor_desconto` int NOT NULL,
  PRIMARY KEY (`id_produto`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `produto`
--

INSERT INTO `produto` (`id_produto`, `nome`, `valor_custo`, `valor_venda`, `qntdC`, `ponto_equilibrio`, `valor_desconto`) VALUES
(1, 'Batata Frita Pequena', 0, 3, 80, NULL, 2),
(2, 'Batata Frita Grande', 0, 7, 80, NULL, 5),
(3, 'Sacolé Fruta', 1, 2, 100, NULL, 1),
(4, 'Sacolé Cremoso', 2, 5, 100, NULL, 3),
(5, 'Cachorro Quente', 3, 5, 30, NULL, 4),
(6, 'Hamburguer', 3, 6, 30, NULL, 4),
(7, 'Pastel', 2.5, 4, 30, NULL, 3),
(8, 'Refri', 2.69, 4, 60, NULL, 3),
(9, 'Enroladinho', 2, 3, 30, NULL, 2),
(10, 'Bolo de pote', 4, 5, 30, NULL, 4);

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario`
--

DROP TABLE IF EXISTS `usuario`;
CREATE TABLE IF NOT EXISTS `usuario` (
  `nome` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `senha` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `id_usuario` int NOT NULL AUTO_INCREMENT,
  `perm` int NOT NULL,
  PRIMARY KEY (`id_usuario`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `usuario`
--

INSERT INTO `usuario` (`nome`, `email`, `senha`, `id_usuario`, `perm`) VALUES
('Lorenzo', 'lorenzodreis@gmail.com', '$2y$10$H/5reKxjCUT4Ryt6I3d/MebIGrMaeeCklxHzoaasnqBeZlJGfex0y', 4, 1),
('Teste', 'teste@gmai.com', '$2y$10$86JWZfmnFNluGD3H1yqJ/.JkSLpS1hzr4UiePlEmHnTxwjQrOoNtO', 5, 0);

-- --------------------------------------------------------

--
-- Estrutura para tabela `vendas`
--

DROP TABLE IF EXISTS `vendas`;
CREATE TABLE IF NOT EXISTS `vendas` (
  `id_venda` int NOT NULL AUTO_INCREMENT,
  `id_produto` int NOT NULL,
  `qtd` int NOT NULL,
  `qntd_desconto` int NOT NULL,
  `tipo` varchar(20) NOT NULL,
  PRIMARY KEY (`id_venda`),
  KEY `id_produto` (`id_produto`)
) ENGINE=InnoDB AUTO_INCREMENT=105 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `vendas`
--
ALTER TABLE `vendas`
  ADD CONSTRAINT `produto_venda` FOREIGN KEY (`id_produto`) REFERENCES `produto` (`id_produto`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
