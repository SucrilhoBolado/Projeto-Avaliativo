-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 16/10/2023 às 21:43
-- Versão do servidor: 10.4.28-MariaDB
-- Versão do PHP: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `projeto_avaliativo`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `chamados`
--

CREATE TABLE `chamados` (
  `id` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `descricao` text NOT NULL,
  `anexos` varchar(255) DEFAULT NULL,
  `status` enum('Aberto','Em atendimento','Finalizado') NOT NULL,
  `data_abertura` datetime DEFAULT current_timestamp(),
  `cliente_id` int(11) DEFAULT NULL,
  `colaborador_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `chamados`
--

INSERT INTO `chamados` (`id`, `titulo`, `descricao`, `anexos`, `status`, `data_abertura`, `cliente_id`, `colaborador_id`) VALUES
(1, 'teste', 'teste', '', 'Finalizado', NULL, 1, NULL),
(5, 'teste', 'teste', '', 'Finalizado', NULL, 1, NULL),
(6, 'aa', 'aa', '', 'Finalizado', NULL, 1, NULL),
(7, 'k', 'teste', '', 'Finalizado', NULL, 1, NULL),
(8, 'usando teste', 'teste', '', 'Finalizado', NULL, 1, NULL),
(9, 'mais um teste', 'teste', '', 'Finalizado', NULL, 1, NULL),
(10, 'teste', 'problema com rede', 'Investimentos.png', 'Finalizado', NULL, 1, NULL),
(11, 'vamos', 'problemas tecnicos', '', 'Finalizado', '2023-10-15 16:29:40', 1, NULL),
(12, 'opa', 'opa123', 'Currículo Simples Minimalista Preto e Branco () (2).pdf', 'Finalizado', '2023-10-15 16:42:39', 1, NULL),
(13, '21', '21', '', 'Finalizado', '2023-10-15 16:44:07', 1, NULL),
(14, 'Estagio em ti', 'teste', '', 'Finalizado', '2023-10-15 17:03:12', 1, NULL),
(15, 'problemas de rede', 'problemas com rede interna\r\n', 'Currículo Simples Minimalista Preto e Branco () (1).pdf', 'Finalizado', '2023-10-15 17:48:02', 1, NULL),
(16, 'outro', 'teste', '', 'Finalizado', '2023-10-16 11:18:35', 1, NULL),
(17, 'problemas com internet', 'problemas com minha rede interna', 'Currículo Simples Minimalista Preto e Branco () (2).pdf', 'Finalizado', '2023-10-16 16:38:12', 1, NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `mensagens`
--

CREATE TABLE `mensagens` (
  `id` int(11) NOT NULL,
  `chamado_id` int(11) NOT NULL,
  `remetente_id` int(11) NOT NULL,
  `mensagem` text NOT NULL,
  `data_envio` timestamp NOT NULL DEFAULT current_timestamp(),
  `remetente` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `mensagens`
--

INSERT INTO `mensagens` (`id`, `chamado_id`, `remetente_id`, `mensagem`, `data_envio`, `remetente`) VALUES
(1, 1, 0, 'kkkkkkk', '2023-10-14 18:57:50', 'Colaborador'),
(2, 1, 0, 'kkkk', '2023-10-14 18:57:56', 'Colaborador'),
(3, 1, 0, 'teste', '2023-10-15 19:19:16', 'Cliente'),
(4, 13, 0, 'opa', '2023-10-15 19:44:22', 'Colaborador'),
(5, 16, 0, 'opa', '2023-10-16 15:40:58', 'Colaborador'),
(6, 17, 0, 'ola boa tarde', '2023-10-16 19:38:25', 'Cliente'),
(7, 17, 0, 'ola boa tarde em que posso ajudar ?\r\n', '2023-10-16 19:38:57', 'Colaborador');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome_completo` varchar(255) NOT NULL,
  `cpf` varchar(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `tipo` enum('Cliente','Colaborador') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome_completo`, `cpf`, `email`, `senha`, `tipo`) VALUES
(1, 'joão', '51639039851', 'alemao123@gmail.com', '$2y$10$e.kwC78k5hUjKmicVD3/1ue9PDD3T1daC3xIrIIlNkENS3pXkLLFu', 'Cliente'),
(2, 'colaborado', '11111111111', 'colaborador@gmail.com', '$2y$10$RK407vkEvpBvh8v5KirUz.2WOslUKXp3Tb0aExvmTclz0p//jumFK', 'Colaborador'),
(3, 'colaborador', '51639539878', 'colaborador123@gmail.com', '$2y$10$fvce8Nu7FnWHKmSVRi3W2.ILwrZ6Rbj30NgUDhFB6H3QYGsabjFXu', 'Colaborador'),
(4, 'amigo', '51639839756', 'amigo@gmail.com', '$2y$10$u1ZbpvTQmX8b0vwpN88Giu4j3BJqdEMYMnwU4fg45RYtvcalRUM7C', 'Cliente'),
(5, 'rodrigo', '21039039856', 'rodrigo@gmail.com', '$2y$10$iqwAyx5e3JnFqXVLKM8GoObKdIpcfpqr8OHQITayBPQ02/F4jwk82', 'Cliente'),
(6, 'teofilo', '21031051630', 'teofilo@gmail.com', '$2y$10$qbSioezLBBPY4cLNg70pH.qGBQ6hMLQfiQtevDourDLCLkocg0sc2', 'Cliente');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `chamados`
--
ALTER TABLE `chamados`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `mensagens`
--
ALTER TABLE `mensagens`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cpf` (`cpf`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `chamados`
--
ALTER TABLE `chamados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de tabela `mensagens`
--
ALTER TABLE `mensagens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
