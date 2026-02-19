-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 16/06/2025 às 01:32
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `tcc_solvetdb`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `avaliacoes`
--

CREATE TABLE `avaliacoes` (
  `id` int(11) NOT NULL,
  `solucao_id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `nota` int(11) DEFAULT NULL,
  `comentario` text DEFAULT NULL,
  `data_avaliacao` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `desafios`
--

CREATE TABLE `desafios` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `titulo` varchar(255) DEFAULT NULL,
  `descricao` text DEFAULT NULL,
  `categoria` varchar(150) DEFAULT NULL,
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `desafios`
--

INSERT INTO `desafios` (`id`, `usuario_id`, `titulo`, `descricao`, `categoria`, `criado_em`) VALUES
(1, 8, 'titulasso', 'complicado fmll', 'tenso', '2025-06-06 19:06:01'),
(2, 9, 'Primeiro post', 'Dando aulas por aqui hein!!', 'chave', '2025-06-06 20:59:40'),
(3, 11, 'Ohh fé', 'Ta chegando a horaaaaa', 'Ansiedade', '2025-06-13 01:09:03'),
(8, 12, 'titulo', 'affffff', 'cate', '2025-06-15 23:20:40');

-- --------------------------------------------------------

--
-- Estrutura para tabela `interacoes`
--

CREATE TABLE `interacoes` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `desafio_id` int(11) DEFAULT NULL,
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `interacoes`
--

INSERT INTO `interacoes` (`id`, `usuario_id`, `desafio_id`, `criado_em`) VALUES
(1, 8, 1, '2025-06-06 20:51:07'),
(2, 9, 1, '2025-06-06 20:58:46'),
(8, 11, 3, '2025-06-15 04:07:38');

-- --------------------------------------------------------

--
-- Estrutura para tabela `metricas`
--

CREATE TABLE `metricas` (
  `id` int(11) NOT NULL,
  `desafio_id` int(11) NOT NULL,
  `total_solucoes` int(11) DEFAULT 0,
  `total_interacoes` int(11) DEFAULT 0,
  `media_avaliacoes` decimal(3,2) DEFAULT 0.00,
  `data_avaliacao` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `solucoes`
--

CREATE TABLE `solucoes` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `desafio_id` int(11) NOT NULL,
  `descricao` text NOT NULL,
  `enviado_em` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `solucoes`
--

INSERT INTO `solucoes` (`id`, `usuario_id`, `desafio_id`, `descricao`, `enviado_em`) VALUES
(1, 8, 1, 'Te entendoooo', '2025-06-06 20:51:18'),
(2, 9, 1, 'Dahora hein, ai sim', '2025-06-06 20:58:58'),
(11, 12, 8, 'opa', '2025-06-15 23:20:48'),
(12, 12, 8, 'ohhh', '2025-06-15 23:22:59');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `biografia` text DEFAULT NULL,
  `nome_empresa` varchar(100) DEFAULT NULL,
  `cargo` varchar(100) DEFAULT NULL,
  `nivel_tecnico` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `email`, `senha`, `biografia`, `nome_empresa`, `cargo`, `nivel_tecnico`) VALUES
(1, 'sbvkj', 'teste@gmail.com', '$2y$10$St0z5LFfWkMQ0z8jeycEJuXSWJBLiwdeTxpsJkFAXwC7/NMcTIuSK', NULL, 'vslknklb', 'snkljsdbv', 'gsgyhws'),
(3, 'sbvkj', 'teste022@gmail.com', '$2y$10$GCbzRcP6xL9Sq3cgOnXhme3RLBJmt3P9lGRIP287.1xWkk/nPQYr2', NULL, 'vslknklb', 'snkljsdbv', 'gsgyhws'),
(4, 'Testeee', 'teste033@gmail.com', '$2y$10$8BRk5cdGb4z.F8a7Hk2STu3v.WTGY7CiMTR3SzjD5/LEuqOy6TbJK', NULL, 'vlksngsd', 'blsjnbs', 'khbvjs'),
(5, 'Testezin', 'teste04@teste.com', '$2y$10$4naev080sb6xa7Sn6oKnJOmDPLX/29DTT5wDtvq6IVK5XR3giUebO', NULL, 'sdhbk', 'agsd', 'gsgyhw'),
(6, 'Testezinho', 'aloo@yahoo.com.br', '$2y$10$cFO/TOOTHHUQY6Bpo8c3EeFhFc.F9UmKgV6IJu2ZZaEU.ANE3TzAa', NULL, 'kçgmlsm', 'snkljsd', 'khbv'),
(7, 'Testezinho.M', 'alooha@yahoo.com.br', '$2y$10$nLovqPBhpcN4TMtvbn/onOOmp2O5WybyQE3cqq.AHj9NmN.5YzRw6', NULL, 'sdhbkl', 'agsdd', 'khbvjss'),
(8, 'Nome', 'email@nada.com', '$2y$10$dz2Ogw7V3taxxt7ptbGDYOpC71IWKuMx9bCJCjhDiEWIEo013E7E6', NULL, '', '', ''),
(9, 'NameDoHomi', 'meuemail@gmail.com', '$2y$10$jyTijK3kns3//44/4H80eO4NapIEcxDsERvpoCT5Ecy0yzyv.82ka', NULL, 'empresasa', 'alto', 'baixo'),
(10, 'OhNome', 'email@gmail.com', '$2y$10$TVaFbqp04Wsbyd6gTNYBTuU7MqO4lYdp8yPyu8LmLFkeVUzryJT62', NULL, '', '', ''),
(11, 'Testezinn', 'teste05@gmail.com', '$2y$10$1oH8eBUI9LgLQ6qrDvrz2e1X4PZtaKGs5TpI4ZUDdpeo.F5JY7VSy', 'Tamo ai né, quem tlgd sabe!!', 'Empresona', 'Top', ''),
(12, 'Teste', 'teste110@gmail.com', '$2y$10$Zu0oZ04EiUrQSvRuh0IouuGDtQwmPsgeJ6WB9Ru3T.pbFFrKz8gJO', 'Nada de novo...', 'Empresona', 'Cargo', '');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `avaliacoes`
--
ALTER TABLE `avaliacoes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `solucao_id` (`solucao_id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Índices de tabela `desafios`
--
ALTER TABLE `desafios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Índices de tabela `interacoes`
--
ALTER TABLE `interacoes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `desafio_id` (`desafio_id`);

--
-- Índices de tabela `metricas`
--
ALTER TABLE `metricas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `desafio_id` (`desafio_id`);

--
-- Índices de tabela `solucoes`
--
ALTER TABLE `solucoes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `desafio_id` (`desafio_id`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `avaliacoes`
--
ALTER TABLE `avaliacoes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `desafios`
--
ALTER TABLE `desafios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `interacoes`
--
ALTER TABLE `interacoes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de tabela `metricas`
--
ALTER TABLE `metricas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `solucoes`
--
ALTER TABLE `solucoes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `avaliacoes`
--
ALTER TABLE `avaliacoes`
  ADD CONSTRAINT `avaliacoes_ibfk_1` FOREIGN KEY (`solucao_id`) REFERENCES `solucoes` (`id`),
  ADD CONSTRAINT `avaliacoes_ibfk_2` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);

--
-- Restrições para tabelas `desafios`
--
ALTER TABLE `desafios`
  ADD CONSTRAINT `desafios_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);

--
-- Restrições para tabelas `interacoes`
--
ALTER TABLE `interacoes`
  ADD CONSTRAINT `interacoes_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `interacoes_ibfk_2` FOREIGN KEY (`desafio_id`) REFERENCES `desafios` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `metricas`
--
ALTER TABLE `metricas`
  ADD CONSTRAINT `metricas_ibfk_1` FOREIGN KEY (`desafio_id`) REFERENCES `desafios` (`id`);

--
-- Restrições para tabelas `solucoes`
--
ALTER TABLE `solucoes`
  ADD CONSTRAINT `solucoes_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `solucoes_ibfk_2` FOREIGN KEY (`desafio_id`) REFERENCES `desafios` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
