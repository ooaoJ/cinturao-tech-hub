-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 13/04/2026 às 22:35
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `tech-hub-v1`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `avaliacao_criterio`
--

CREATE TABLE `avaliacao_criterio` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `avaliacao_id` bigint(20) UNSIGNED NOT NULL,
  `criterio_id` bigint(20) UNSIGNED NOT NULL,
  `nota` decimal(5,2) NOT NULL,
  `comentario` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `avaliacoes`
--

CREATE TABLE `avaliacoes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `projeto_id` bigint(20) UNSIGNED NOT NULL,
  `avaliador_id` bigint(20) UNSIGNED NOT NULL,
  `comentario_geral` text DEFAULT NULL,
  `nota_final` decimal(5,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `cargos`
--

CREATE TABLE `cargos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nome` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `cargos`
--

INSERT INTO `cargos` (`id`, `nome`, `created_at`, `updated_at`) VALUES
(1, 'Aluno', '2026-04-13 18:25:33', '2026-04-13 18:25:33'),
(2, 'Orientador', '2026-04-13 18:25:33', '2026-04-13 18:25:33');

-- --------------------------------------------------------

--
-- Estrutura para tabela `cidades`
--

CREATE TABLE `cidades` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nome` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `cidades`
--

INSERT INTO `cidades` (`id`, `nome`, `created_at`, `updated_at`) VALUES
(1, 'Presidente Prudente', '2026-04-13 18:22:39', '2026-04-13 18:22:39'),
(2, 'Osvaldo Cruz', '2026-04-13 18:22:39', '2026-04-13 18:22:39'),
(3, 'Regente Feijó', '2026-04-13 18:22:39', '2026-04-13 18:22:39'),
(4, 'Presidente Epitácio', '2026-04-13 18:22:39', '2026-04-13 18:22:39'),
(5, 'Santo Anastácio', '2026-04-13 18:22:39', '2026-04-13 18:22:39');

-- --------------------------------------------------------

--
-- Estrutura para tabela `criterios`
--

CREATE TABLE `criterios` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nome` varchar(255) NOT NULL,
  `tipo` varchar(255) NOT NULL,
  `descricao` text DEFAULT NULL,
  `peso` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `criterios`
--

INSERT INTO `criterios` (`id`, `nome`, `tipo`, `descricao`, `peso`, `created_at`, `updated_at`) VALUES
(2, 'Comunicação', 'soft', 'Capacidade de comunicação da equipe, entrosamento e entendimento do que é conversado.', 1, '2026-04-13 18:33:50', '2026-04-13 18:33:50'),
(3, 'Trabalho em Equipe', 'soft', 'Colaboração entre os membros e divisão equilibrada de tarefas.', 1, '2026-04-13 18:33:50', '2026-04-13 18:33:50'),
(4, 'Proatividade', 'soft', 'Iniciativa para resolver problemas sem depender totalmente de orientação externa.', 1, '2026-04-13 18:33:50', '2026-04-13 18:33:50'),
(5, 'Organização', 'soft', 'Capacidade de organizar tarefas, tempo e entregas do projeto.', 1, '2026-04-13 18:33:50', '2026-04-13 18:33:50'),
(6, 'Apresentação', 'soft', 'Clareza e qualidade na apresentação da solução para avaliadores.', 1, '2026-04-13 18:33:50', '2026-04-13 18:33:50'),
(7, 'Qualidade do Código', 'hard', 'Código bem estruturado, limpo, organizado e seguindo boas práticas.', 2, '2026-04-13 18:33:50', '2026-04-13 18:33:50'),
(8, 'Arquitetura do Sistema', 'hard', 'Estrutura do sistema bem definida (MVC, API, separação de responsabilidades).', 2, '2026-04-13 18:33:50', '2026-04-13 18:33:50'),
(9, 'Resolução do Problema', 'hard', 'Efetividade da solução em resolver o problema industrial proposto.', 3, '2026-04-13 18:33:50', '2026-04-13 18:33:50'),
(10, 'Usabilidade (UX/UI)', 'hard', 'Facilidade de uso e qualidade da interface do sistema.', 2, '2026-04-13 18:33:50', '2026-04-13 18:33:50'),
(11, 'Funcionalidade', 'hard', 'Se o sistema funciona corretamente conforme os requisitos.', 3, '2026-04-13 18:33:50', '2026-04-13 18:33:50'),
(12, 'Inovação', 'hard', 'Nível de inovação e criatividade da solução proposta.', 2, '2026-04-13 18:33:50', '2026-04-13 18:33:50'),
(13, 'Documentação', 'hard', 'Qualidade da documentação (regras de negócio, requisitos, etc).', 1, '2026-04-13 18:33:50', '2026-04-13 18:33:50');

-- --------------------------------------------------------

--
-- Estrutura para tabela `documentos_projeto`
--

CREATE TABLE `documentos_projeto` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `projeto_id` bigint(20) UNSIGNED NOT NULL,
  `tipo` varchar(255) NOT NULL,
  `arquivo` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `equipes`
--

CREATE TABLE `equipes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nome` varchar(255) NOT NULL,
  `orientador_id` bigint(20) UNSIGNED NOT NULL,
  `cidade_id` bigint(20) UNSIGNED NOT NULL,
  `etapa_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `equipe_user`
--

CREATE TABLE `equipe_user` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `equipe_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `funcao_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `etapas`
--

CREATE TABLE `etapas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cidade_id` bigint(20) UNSIGNED NOT NULL,
  `nome` varchar(255) NOT NULL,
  `data_inicio` date NOT NULL,
  `data_final` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `funcoes_equipe`
--

CREATE TABLE `funcoes_equipe` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nome` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `funcoes_equipe`
--

INSERT INTO `funcoes_equipe` (`id`, `nome`, `created_at`, `updated_at`) VALUES
(1, 'Product Owner', '2026-04-13 18:30:01', '2026-04-13 18:30:01'),
(2, 'Developer', '2026-04-13 18:30:01', '2026-04-13 18:30:01'),
(3, 'UI/UX Designer', '2026-04-13 18:30:01', '2026-04-13 18:30:01'),
(4, 'QA/Tester', '2026-04-13 18:30:01', '2026-04-13 18:30:01');

-- --------------------------------------------------------

--
-- Estrutura para tabela `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000001_create_cache_table', 1),
(2, '0001_01_01_000002_create_jobs_table', 1),
(3, '2026_04_13_165444_create_cargos_table', 1),
(4, '2026_04_13_165502_create_cidades_table', 1),
(5, '2026_04_13_165503_create_users_table', 1),
(6, '2026_04_13_165540_create_etapas_table', 1),
(7, '2026_04_13_165549_create_funcoes_equipe_table', 1),
(8, '2026_04_13_165556_create_equipes_table', 1),
(9, '2026_04_13_165604_create_equipe_user_table', 1),
(10, '2026_04_13_165613_create_projetos_table', 1),
(11, '2026_04_13_165624_create_documentos_projeto_table', 1),
(12, '2026_04_13_165631_create_testes_table', 1),
(13, '2026_04_13_165637_create_criterios_table', 1),
(14, '2026_04_13_165652_create_avaliacoes_table', 1),
(15, '2026_04_13_165700_create_avaliacao_criterio_table', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `projetos`
--

CREATE TABLE `projetos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `equipe_id` bigint(20) UNSIGNED NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `descricao` text NOT NULL,
  `problema_resolvido` text NOT NULL,
  `link_prototipo` varchar(255) DEFAULT NULL,
  `link_repositorio` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'rascunho',
  `aprovado_orientador` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('NcNb2gYzy7jH37pMbCzIHc3DvHD44G9U24ytE2y2', NULL, '127.0.0.1', 'PostmanRuntime/7.53.0', 'eyJfdG9rZW4iOiJWRWZTTG5IR1hIMGM2Tk1EeVdaNVVXM2d3c1BlN2dlaGZMak82WUthIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwIiwicm91dGUiOm51bGx9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19', 1776103778),
('YBe40hHOXtm6wAjxroCospcgp7eK27fsfyqb62HZ', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', 'eyJfdG9rZW4iOiJKRlpsT0JXSDcxRWl5dGFqbXpVbFVGTmtlSjRrMU42N254V2VBdGZxIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwIiwicm91dGUiOm51bGx9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19', 1776102893);

-- --------------------------------------------------------

--
-- Estrutura para tabela `testes`
--

CREATE TABLE `testes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `projeto_id` bigint(20) UNSIGNED NOT NULL,
  `descricao` text NOT NULL,
  `data_teste` date DEFAULT NULL,
  `resultado` varchar(255) DEFAULT NULL,
  `observacoes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `matricula` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pendente',
  `cargo_id` bigint(20) UNSIGNED NOT NULL,
  `cidade_id` bigint(20) UNSIGNED NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `users`
--

INSERT INTO `users` (`id`, `name`, `matricula`, `password`, `status`, `cargo_id`, `cidade_id`, `foto`, `bio`, `remember_token`, `created_at`, `updated_at`) VALUES
(2, 'João Pedro Sperandio', '123123123', '$2y$12$w8XrqqsqXIY8NdwBiZpfhu.jbl5jouCvVDY9yTeKq0pE2zlluPmAa', 'aprovado', 1, 1, NULL, NULL, NULL, '2026-04-13 21:42:35', '2026-04-13 22:03:27'),
(3, 'Nilo', '77777777', '$2y$12$uebAl6giefnWVnKRtkQmZO5fUDcyoyLx8d7WsVU4.yZYbkc3l/nDq', 'aprovado', 2, 3, NULL, NULL, NULL, '2026-04-13 21:56:18', '2026-04-13 21:56:18');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `avaliacao_criterio`
--
ALTER TABLE `avaliacao_criterio`
  ADD PRIMARY KEY (`id`),
  ADD KEY `avaliacao_criterio_avaliacao_id_foreign` (`avaliacao_id`),
  ADD KEY `avaliacao_criterio_criterio_id_foreign` (`criterio_id`);

--
-- Índices de tabela `avaliacoes`
--
ALTER TABLE `avaliacoes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `avaliacoes_projeto_id_foreign` (`projeto_id`),
  ADD KEY `avaliacoes_avaliador_id_foreign` (`avaliador_id`);

--
-- Índices de tabela `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Índices de tabela `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Índices de tabela `cargos`
--
ALTER TABLE `cargos`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `cidades`
--
ALTER TABLE `cidades`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `criterios`
--
ALTER TABLE `criterios`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `documentos_projeto`
--
ALTER TABLE `documentos_projeto`
  ADD PRIMARY KEY (`id`),
  ADD KEY `documentos_projeto_projeto_id_foreign` (`projeto_id`);

--
-- Índices de tabela `equipes`
--
ALTER TABLE `equipes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `equipes_orientador_id_foreign` (`orientador_id`),
  ADD KEY `equipes_cidade_id_foreign` (`cidade_id`),
  ADD KEY `equipes_etapa_id_foreign` (`etapa_id`);

--
-- Índices de tabela `equipe_user`
--
ALTER TABLE `equipe_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `equipe_user_user_id_unique` (`user_id`),
  ADD KEY `equipe_user_equipe_id_foreign` (`equipe_id`),
  ADD KEY `equipe_user_funcao_id_foreign` (`funcao_id`);

--
-- Índices de tabela `etapas`
--
ALTER TABLE `etapas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `etapas_cidade_id_foreign` (`cidade_id`);

--
-- Índices de tabela `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Índices de tabela `funcoes_equipe`
--
ALTER TABLE `funcoes_equipe`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Índices de tabela `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Índices de tabela `projetos`
--
ALTER TABLE `projetos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `projetos_equipe_id_foreign` (`equipe_id`);

--
-- Índices de tabela `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Índices de tabela `testes`
--
ALTER TABLE `testes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `testes_projeto_id_foreign` (`projeto_id`);

--
-- Índices de tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_matricula_unique` (`matricula`),
  ADD KEY `users_cargo_id_foreign` (`cargo_id`),
  ADD KEY `users_cidade_id_foreign` (`cidade_id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `avaliacao_criterio`
--
ALTER TABLE `avaliacao_criterio`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `avaliacoes`
--
ALTER TABLE `avaliacoes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `cargos`
--
ALTER TABLE `cargos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `cidades`
--
ALTER TABLE `cidades`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `criterios`
--
ALTER TABLE `criterios`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de tabela `documentos_projeto`
--
ALTER TABLE `documentos_projeto`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `equipes`
--
ALTER TABLE `equipes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `equipe_user`
--
ALTER TABLE `equipe_user`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `etapas`
--
ALTER TABLE `etapas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `funcoes_equipe`
--
ALTER TABLE `funcoes_equipe`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de tabela `projetos`
--
ALTER TABLE `projetos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `testes`
--
ALTER TABLE `testes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `avaliacao_criterio`
--
ALTER TABLE `avaliacao_criterio`
  ADD CONSTRAINT `avaliacao_criterio_avaliacao_id_foreign` FOREIGN KEY (`avaliacao_id`) REFERENCES `avaliacoes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `avaliacao_criterio_criterio_id_foreign` FOREIGN KEY (`criterio_id`) REFERENCES `criterios` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `avaliacoes`
--
ALTER TABLE `avaliacoes`
  ADD CONSTRAINT `avaliacoes_avaliador_id_foreign` FOREIGN KEY (`avaliador_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `avaliacoes_projeto_id_foreign` FOREIGN KEY (`projeto_id`) REFERENCES `projetos` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `documentos_projeto`
--
ALTER TABLE `documentos_projeto`
  ADD CONSTRAINT `documentos_projeto_projeto_id_foreign` FOREIGN KEY (`projeto_id`) REFERENCES `projetos` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `equipes`
--
ALTER TABLE `equipes`
  ADD CONSTRAINT `equipes_cidade_id_foreign` FOREIGN KEY (`cidade_id`) REFERENCES `cidades` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `equipes_etapa_id_foreign` FOREIGN KEY (`etapa_id`) REFERENCES `etapas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `equipes_orientador_id_foreign` FOREIGN KEY (`orientador_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `equipe_user`
--
ALTER TABLE `equipe_user`
  ADD CONSTRAINT `equipe_user_equipe_id_foreign` FOREIGN KEY (`equipe_id`) REFERENCES `equipes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `equipe_user_funcao_id_foreign` FOREIGN KEY (`funcao_id`) REFERENCES `funcoes_equipe` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `equipe_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `etapas`
--
ALTER TABLE `etapas`
  ADD CONSTRAINT `etapas_cidade_id_foreign` FOREIGN KEY (`cidade_id`) REFERENCES `cidades` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `projetos`
--
ALTER TABLE `projetos`
  ADD CONSTRAINT `projetos_equipe_id_foreign` FOREIGN KEY (`equipe_id`) REFERENCES `equipes` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `testes`
--
ALTER TABLE `testes`
  ADD CONSTRAINT `testes_projeto_id_foreign` FOREIGN KEY (`projeto_id`) REFERENCES `projetos` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_cargo_id_foreign` FOREIGN KEY (`cargo_id`) REFERENCES `cargos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `users_cidade_id_foreign` FOREIGN KEY (`cidade_id`) REFERENCES `cidades` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
