-- phpMyAdmin SQL Dump
-- version 4.5.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 30-Jan-2019 às 15:08
-- Versão do servidor: 5.7.11
-- PHP Version: 7.0.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sitrad`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `acoes`
--

CREATE TABLE `acoes` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `acoes`
--

INSERT INTO `acoes` (`id`, `name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Novo', '2019-01-12 10:21:27', '2019-01-12 10:21:27', NULL),
(2, 'Protocolado', '2019-01-12 10:21:27', '2019-01-12 10:21:27', NULL),
(3, 'Em Análise', '2019-01-12 10:21:27', '2019-01-12 10:21:27', NULL),
(4, 'Tramite', '2019-01-12 10:21:27', '2019-01-12 10:21:27', NULL),
(5, 'Resposta', '2019-01-12 10:21:27', '2019-01-12 10:21:27', NULL),
(6, 'Finalizado', '2019-01-12 10:21:27', '2019-01-12 10:21:27', NULL),
(7, 'Cancelado', '2019-01-12 10:21:27', '2019-01-12 10:21:27', NULL),
(8, 'Deferido', '2019-01-12 10:21:27', '2019-01-12 10:21:27', NULL),
(9, 'Indeferido', '2019-01-12 10:21:27', '2019-01-12 10:21:27', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `campos`
--

CREATE TABLE `campos` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `campos`
--

INSERT INTO `campos` (`id`, `name`, `tipo`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Texto', 'varchar', '2019-01-14 03:28:28', '2019-01-14 03:28:28', NULL),
(2, 'Numero', 'char', '2019-01-14 03:28:29', '2019-01-14 03:28:29', NULL),
(3, 'Data', 'timestamp', '2019-01-14 03:28:29', '2019-01-14 03:28:29', NULL),
(4, 'Email', 'varchar', '2019-01-14 03:28:29', '2019-01-14 03:28:29', NULL),
(5, 'Text Area', 'text', '2019-01-14 03:28:29', '2019-01-14 03:28:29', NULL),
(6, 'Inteiro', 'int', '2019-01-14 09:12:15', '2019-01-14 09:12:15', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `campos_requerimentos`
--

CREATE TABLE `campos_requerimentos` (
  `id` int(10) UNSIGNED NOT NULL,
  `requerimento_id` int(10) UNSIGNED NOT NULL,
  `campo_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `label` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `placeholder` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tamanho` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `cursos`
--

CREATE TABLE `cursos` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `cursos`
--

INSERT INTO `cursos` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'ANÁLISE E DESENVOLVIMENTO DE SISTEMAS', '2019-01-14 14:11:44', '2019-01-14 14:11:44'),
(2, 'BACHARELADO EM ADMINISTRAÇÃO', '2019-01-14 14:11:44', '2019-01-14 14:11:44'),
(3, 'BACHARELADO EM AGRONOMIA', '2019-01-14 14:11:44', '2019-01-14 14:11:44'),
(4, 'BACHARELADO EM ENGENHARIA CIVIL', '2019-01-14 14:11:44', '2019-01-14 14:11:44'),
(5, 'BACHARELADO EM SISTEMAS DE INFORMAÇÃO', '2019-01-14 14:11:44', '2019-01-14 14:11:44'),
(6, 'ENGENHARIA AGRÍCOLA E AMBIENTAL', '2019-01-14 14:11:44', '2019-01-14 14:11:44'),
(7, 'LICENCIATURA EM CIENCIAS BIOLÓGICAS', '2019-01-14 14:11:44', '2019-01-14 14:11:44'),
(8, 'LICENCIATURA EM FÍSICA', '2019-01-14 14:11:44', '2019-01-14 14:11:44'),
(9, 'LICENCIATURA EM MATEMÁTICA', '2019-01-14 14:11:44', '2019-01-14 14:11:44');

-- --------------------------------------------------------

--
-- Estrutura da tabela `curso_user`
--

CREATE TABLE `curso_user` (
  `id` int(11) NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `curso_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `historicos`
--

CREATE TABLE `historicos` (
  `id` int(10) UNSIGNED NOT NULL,
  `solicitacao_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `acao_id` int(10) UNSIGNED NOT NULL,
  `valor` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `resposta` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `permissions`
--

CREATE TABLE `permissions` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `label` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `label`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'tramite', 'Permissão para realizar tramite de documentos entre os setores.', '2019-01-12 15:13:21', '2019-01-12 15:13:21', NULL),
(2, 'gestao_user', 'Gestão de usuários e funções cadastrados no sistema.', '2019-01-12 15:13:21', '2019-01-12 15:13:21', NULL),
(3, 'gestao_requerimento', 'Gestão dos requerimentos cadastrados no sistema.', '2018-12-02 02:00:00', '2018-12-22 02:00:00', NULL),
(4, 'solicitar_requerimento', 'Permissão exclusiva para alunos solicitarem requerimentos.', '2019-01-12 15:13:21', '2019-01-12 15:13:21', NULL),
(5, 'consultar_requerimento', 'Consultar Requerimentos cadastrados no sistema.', '2019-01-19 15:09:16', '2019-01-19 09:22:17', NULL),
(9, 'admin', 'Todas as permissões.', '2019-01-19 15:09:16', '2019-01-19 09:22:17', NULL),
(10, 'protocolo', 'Protocolar e/ou cancelar as solicitações', '2019-01-19 15:09:16', '2019-01-14 09:12:15', NULL),
(12, 'view_solicitacao', 'Visualizar as informações preenchidas na solicitação.', '2019-01-19 15:09:16', '2019-01-19 15:09:16', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `permission_role`
--

CREATE TABLE `permission_role` (
  `id` int(10) UNSIGNED NOT NULL,
  `permission_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `permission_role`
--

INSERT INTO `permission_role` (`id`, `permission_id`, `role_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 2, NULL, NULL, NULL),
(9, 9, 3, '2019-01-19 15:09:16', '2019-01-14 09:12:15', NULL),
(3, 3, 2, '2018-12-02 02:00:00', '2019-01-09 13:14:27', NULL),
(4, 4, 1, '2019-01-12 15:13:21', '2019-01-12 15:13:21', NULL),
(5, 2, 2, '2019-01-12 15:13:21', '2019-01-12 15:13:21', NULL),
(6, 5, 2, '2019-01-19 15:09:16', '2019-01-14 09:12:15', NULL),
(29, 5, 6, '2019-01-20 16:58:30', '2019-01-20 16:58:30', NULL),
(28, 12, 5, '2019-01-20 16:30:49', '2019-01-20 16:30:49', NULL),
(24, 5, 5, '2019-01-20 04:36:05', '2019-01-20 04:36:05', NULL),
(27, 12, 1, '2019-01-20 16:30:35', '2019-01-20 16:30:35', NULL),
(25, 10, 5, '2019-01-20 04:36:05', '2019-01-20 04:36:05', NULL),
(30, 1, 6, '2019-01-20 16:58:30', '2019-01-20 16:58:30', NULL),
(31, 12, 6, '2019-01-20 16:58:30', '2019-01-20 16:58:30', NULL),
(32, 5, 7, '2019-01-20 17:00:14', '2019-01-20 17:00:14', NULL),
(33, 1, 7, '2019-01-20 17:00:14', '2019-01-20 17:00:14', NULL),
(34, 12, 7, '2019-01-20 17:00:14', '2019-01-20 17:00:14', NULL),
(35, 12, 8, '2019-01-20 20:22:06', '2019-01-20 20:22:06', NULL),
(37, 1, 8, '2019-01-21 04:22:38', '2019-01-21 04:22:38', NULL),
(39, 12, 2, '2019-01-21 04:39:04', '2019-01-21 04:39:04', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `requerimentos`
--

CREATE TABLE `requerimentos` (
  `id` int(10) UNSIGNED NOT NULL,
  `tipo_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `table_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `passos` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `informacoes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `label` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `roles`
--

INSERT INTO `roles` (`id`, `name`, `label`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'aluno', 'Aluno', NULL, NULL, NULL),
(2, 'des', 'Diretor de Ensino Superior', '2018-12-02 02:00:00', '2018-12-22 02:00:00', NULL),
(3, 'admin', 'Administrador do sistema', '2019-01-09 13:14:27', '2019-01-09 13:14:27', NULL),
(6, 'sra', 'Secretaria de Registros Acadêmicos', '2019-01-20 16:57:52', '2019-01-20 16:57:52', NULL),
(5, 'atendimento_sra', 'Atendimento SRA', '2019-01-20 04:34:20', '2019-01-20 04:34:20', NULL),
(7, 'coordenacao_sra', 'Coordenação Secretaria de Registros Acadêmicos', '2019-01-20 16:59:36', '2019-01-20 16:59:36', NULL),
(8, 'coordenacao', 'Coordenação de Curso', '2019-01-20 20:21:33', '2019-01-20 20:21:33', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `role_user`
--

CREATE TABLE `role_user` (
  `id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `role_user`
--

INSERT INTO `role_user` (`id`, `role_id`, `user_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(5, 3, 7, '2019-01-05 01:54:41', '2019-01-05 01:54:41', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `solicitacoes`
--

CREATE TABLE `solicitacoes` (
  `id` int(10) UNSIGNED NOT NULL,
  `requerimento_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `status_atual` int(11) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tipos`
--

CREATE TABLE `tipos` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `matricula` char(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cpf` char(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `username`, `matricula`, `cpf`, `password`, `status`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(7, 'Administrador', 'sitrad@gmail.com', 'admin', '147852', '40044077025', '$2y$10$FQiW.VjCXIDsXfn1/fnOs.xE0U4Mv/78b2faEBZ.yoSDck6dFzjIm', '', 'PHekTAD5LAs171i0m8H2pGmZcx9gx7xWx3yW2VrJFAXOWJg4heVxIAy9pvYp', '2019-01-05 01:54:41', '2019-01-30 15:03:21', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `acoes`
--
ALTER TABLE `acoes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `campos`
--
ALTER TABLE `campos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `campos_requerimentos`
--
ALTER TABLE `campos_requerimentos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `campos_requerimentos_user_id_foreign` (`requerimento_id`),
  ADD KEY `campos_requerimentos_campo_id_foreign` (`campo_id`);

--
-- Indexes for table `cursos`
--
ALTER TABLE `cursos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `curso_user`
--
ALTER TABLE `curso_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `historicos`
--
ALTER TABLE `historicos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `historicos_solicitacao_id_foreign` (`solicitacao_id`),
  ADD KEY `historicos_user_id_foreign` (`user_id`),
  ADD KEY `historicos_acao_id_foreign` (`acao_id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD PRIMARY KEY (`id`),
  ADD KEY `permission_role_permission_id_foreign` (`permission_id`),
  ADD KEY `permission_role_role_id_foreign` (`role_id`);

--
-- Indexes for table `requerimentos`
--
ALTER TABLE `requerimentos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `requerimentos_tipo_id_foreign` (`tipo_id`),
  ADD KEY `requerimentos_user_id_foreign` (`user_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_user`
--
ALTER TABLE `role_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_user_role_id_foreign` (`role_id`),
  ADD KEY `role_user_user_id_foreign` (`user_id`);

--
-- Indexes for table `solicitacoes`
--
ALTER TABLE `solicitacoes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `solicitacoes_requerimento_id_foreign` (`requerimento_id`),
  ADD KEY `solicitacoes_user_id_foreign` (`user_id`);

--
-- Indexes for table `tipos`
--
ALTER TABLE `tipos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD UNIQUE KEY `users_cpf_unique` (`cpf`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `acoes`
--
ALTER TABLE `acoes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `campos`
--
ALTER TABLE `campos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `campos_requerimentos`
--
ALTER TABLE `campos_requerimentos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
--
-- AUTO_INCREMENT for table `cursos`
--
ALTER TABLE `cursos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `curso_user`
--
ALTER TABLE `curso_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;
--
-- AUTO_INCREMENT for table `historicos`
--
ALTER TABLE `historicos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;
--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `permission_role`
--
ALTER TABLE `permission_role`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;
--
-- AUTO_INCREMENT for table `requerimentos`
--
ALTER TABLE `requerimentos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `role_user`
--
ALTER TABLE `role_user`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
--
-- AUTO_INCREMENT for table `solicitacoes`
--
ALTER TABLE `solicitacoes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
--
-- AUTO_INCREMENT for table `tipos`
--
ALTER TABLE `tipos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
