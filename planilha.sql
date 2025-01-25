-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 25/01/2025 às 00:20
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
  `valor_desconto` int NOT NULL,
  `qntdC` int NOT NULL,
  `ponto_equilibrio` time DEFAULT NULL,
  PRIMARY KEY (`id_produto`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `produto`
--

INSERT INTO `produto` (`id_produto`, `nome`, `valor_custo`, `valor_venda`, `valor_desconto`, `qntdC`, `ponto_equilibrio`) VALUES
(1, 'Pepsi', 2.98, 5, 4, 12, NULL),
(2, 'Guaraná', 2.55, 5, 4, 12, NULL),
(3, 'Sacolé Fruta', 1, 2, 1, 120, NULL),
(4, 'Sacolé Cremoso', 2, 3, 2, 120, NULL),
(5, 'Cachorro Quente', 3.5, 5, 4, 60, NULL),
(6, 'Hamburguer', 4, 6, 5, 60, NULL),
(7, 'Pastel', 3.5, 5, 4, 60, NULL),
(8, 'Coca Cola', 2.89, 5, 4, 24, NULL),
(9, 'Enroladinho', 2.5, 4, 3, 50, NULL),
(10, 'Bolo de pote', 4, 7, 5, 30, NULL),
(11, 'Coca Zero', 3.38, 5, 4, 12, NULL),
(12, 'Total', 0, 0, 0, 0, NULL),
(13, 'Pipoca', 9.5, 2, 1, 4, NULL);

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
('Adm', 'adm@gmail.com', '$2y$10$86JWZfmnFNluGD3H1yqJ/.JkSLpS1hzr4UiePlEmHnTxwjQrOoNtO', 5, 0);

-- --------------------------------------------------------

--
-- Estrutura para tabela `vendas`
--

DROP TABLE IF EXISTS `vendas`;
CREATE TABLE IF NOT EXISTS `vendas` (
  `id_venda` int NOT NULL AUTO_INCREMENT,
  `id_produto` int NOT NULL,
  `qtd` int DEFAULT NULL,
  `qntd_desconto` int DEFAULT NULL,
  `tipo` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  PRIMARY KEY (`id_venda`),
  KEY `id_produto` (`id_produto`)
) ENGINE=InnoDB AUTO_INCREMENT=170 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
