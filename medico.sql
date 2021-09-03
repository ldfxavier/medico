-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: mariadb-medico:3306
-- Generation Time: 03-Set-2021 às 17:55
-- Versão do servidor: 10.1.26-MariaDB-1~jessie
-- PHP Version: 7.2.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `medico`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `admin_status`
--

CREATE TABLE `admin_status` (
  `id` int(11) NOT NULL,
  `cod` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `empresa` int(11) DEFAULT NULL,
  `tabela` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Local',
  `campo` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Tipo',
  `valor` int(11) DEFAULT NULL COMMENT 'Valor',
  `nome` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Nome',
  `cor` char(7) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Cor',
  `data_criacao` datetime DEFAULT NULL,
  `data_atualizacao` datetime DEFAULT NULL,
  `ordem` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `admin_status`
--

INSERT INTO `admin_status` (`id`, `cod`, `empresa`, `tabela`, `campo`, `valor`, `nome`, `cor`, `data_criacao`, `data_atualizacao`, `ordem`) VALUES
(1, 'a5ddb4a21ef64dd0ea2aa0ccabbf0c09', NULL, 'banner', 'status', 1, 'Ativo', '#16A085', '2018-05-16 14:28:49', NULL, 1),
(2, '997e9dc4332f7e2d1d5872818c40346d', NULL, 'banner', 'status', 2, 'Inativo', '#E05D6F', '2018-05-16 14:29:05', NULL, 2),
(3, '7fe1ba26ae5dcd22ab17b728179e5d5e', NULL, 'banner', 'tipo', 1, 'Publicidade do topo', '#00A7F6', '2018-05-16 14:50:49', '2018-06-07 15:34:12', 1),
(4, '42f4d999faf6a9ccc1c92e797806d55e', NULL, 'banner', 'tipo', 2, 'Banner principal', '#FF1493', '2018-05-16 14:51:25', '2018-06-07 15:34:02', 1),
(8, 'a7bd493e241553d62fa5614e2ba7a464', NULL, 'usuario', 'status', 1, 'Ativo', '#16A085', '2018-06-01 10:59:36', NULL, 1),
(9, '79c5fb3778fa456282b629c6a83df3e3', NULL, 'usuario', 'status', 2, 'Inativo', '#E05D6F', '2018-06-01 10:59:50', NULL, 2),
(10, 'de3ca0a765570e56fcdeda7c8cd12bf2', NULL, 'usuario', 'status', 3, 'Bloqueado', '#FFA500', '2018-06-01 11:00:07', NULL, 3),
(11, '71a630273822cba30dda65e4593eebd9', NULL, 'mensagem', 'status', 1, 'Novo', '#E05D6F', '2018-06-29 17:19:36', NULL, 1),
(12, 'bdf0f236615265809240f3662a9a4194', NULL, 'mensagem', 'status', 2, 'Em andamento', '#00A7F6', '2018-06-29 17:19:55', NULL, 2),
(13, 'c8262c9cb17505d6f6bc3837a5ad5dda', NULL, 'mensagem', 'status', 3, 'Finalizado', '#16A085', '2018-06-29 17:20:10', NULL, 3),
(14, '3930176795af801256689726cae2cc8b', NULL, 'equipe', 'status', 1, 'Ativo', '#16A085', '2018-06-29 17:26:20', NULL, 1),
(15, '629159a565c1332c97a0fb1b4d5e2966', NULL, 'equipe', 'status', 2, 'Inativo', '#E05D6F', '2018-06-29 17:26:36', NULL, 2),
(16, 'e8bd335396a50e5e3d4eb247aa8e2d97', NULL, 'equipe', 'status', 3, 'Bloqueado', '#FFA500', '2018-06-29 17:27:03', NULL, 3);

-- --------------------------------------------------------

--
-- Estrutura da tabela `data_log`
--

CREATE TABLE `data_log` (
  `id` int(11) NOT NULL,
  `cod` char(36) NOT NULL,
  `tipo` int(11) NOT NULL,
  `app` varchar(150) DEFAULT NULL,
  `usuario` int(11) NOT NULL,
  `uri_acessada` varchar(100) NOT NULL,
  `retorno` text,
  `metodo_utilizado` varchar(6) NOT NULL,
  `dado_enviado` text,
  `header_enviado` text NOT NULL,
  `ip_usuario` varchar(15) NOT NULL,
  `status_html` int(3) NOT NULL,
  `data_criacao` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `data_log`
--

INSERT INTO `data_log` (`id`, `cod`, `tipo`, `app`, `usuario`, `uri_acessada`, `retorno`, `metodo_utilizado`, `dado_enviado`, `header_enviado`, `ip_usuario`, `status_html`, `data_criacao`) VALUES
(1, 'bce72b0d-336c-4c64-adbc-73f51478a6b8', 1, NULL, 1, 'post-login', NULL, 'POST', NULL, '{\"Host\":\"localhost:4013\",\"Connection\":\"keep-alive\",\"Content-Length\":\"35\",\"sec-ch-ua\":\"\\\"Chromium\\\";v=\\\"92\\\", \\\" Not A;Brand\\\";v=\\\"99\\\", \\\"Google Chrome\\\";v=\\\"92\\\"\",\"Accept\":\"application\\/json, text\\/javascript, *\\/*; q=0.01\",\"X-Requested-With\":\"XMLHttpRequest\",\"sec-ch-ua-mobile\":\"?0\",\"User-Agent\":\"Mozilla\\/5.0 (X11; Linux x86_64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/92.0.4515.159 Safari\\/537.36\",\"Content-Type\":\"application\\/x-www-form-urlencoded; charset=UTF-8\",\"Origin\":\"http:\\/\\/localhost:4013\",\"Sec-Fetch-Site\":\"same-origin\",\"Sec-Fetch-Mode\":\"cors\",\"Sec-Fetch-Dest\":\"empty\",\"Referer\":\"http:\\/\\/localhost:4013\\/painel\\/painel\\/login\",\"Accept-Encoding\":\"gzip, deflate, br\",\"Accept-Language\":\"pt-BR,pt;q=0.9,en-US;q=0.8,en;q=0.7\",\"Cookie\":\"_ga=GA1.1.1083799749.1624978053; _hjid=c5ad29fa-e649-430f-a170-13df00a9127d; _ga_D14Y6W23D9=GS1.1.1625004578.2.0.1625004688.0; pmaCookieVer=5; pma_lang=pt; pma_collation_connection=utf8mb4_unicode_ci; PHPSESSID=db14e7fdf98a3eddbd675f7192630144; _ga_J8T0443JNB=GS1.1.1630524040.11.0.1630524040.0; pma_console_height=92; pma_console_config=%7B%22alwaysExpand%22%3Afalse%2C%22startHistory%22%3Afalse%2C%22currentQuery%22%3Atrue%2C%22enterExecutes%22%3Afalse%2C%22darkTheme%22%3Afalse%7D; pma_console_mode=collapse; phpMyAdmin=6d4b69d698e8b64f918abf09a00b7b14; pmaUser-1=%7B%22iv%22%3A%22Y%2B%5C%2Fzi9Oy8TPPVnuX8NOB8g%3D%3D%22%2C%22mac%22%3A%224222995f6bd4af1e2fc188820d8e32bdf83e33bf%22%2C%22payload%22%3A%22ptkSfKz3dO2r32vRwGSfug%3D%3D%22%7D; pmaAuth-1=%7B%22iv%22%3A%22D4eoKN%2BP4B%5C%2FO1H9ImuQY%5C%2FQ%3D%3D%22%2C%22mac%22%3A%22ff0d8612e2359cb4acb3b6867d9a0a48aba4dc7a%22%2C%22payload%22%3A%22LnfZhJI%5C%2FyG5lSFeG3dT%2Bx9sywBeDFTY5toa%2B4x%2BZpaU%3D%22%7D\"}', '172.23.0.1', 200, '2021-09-03 14:55:19');

-- --------------------------------------------------------

--
-- Estrutura da tabela `drive`
--

CREATE TABLE `drive` (
  `id` int(11) NOT NULL,
  `cod` char(32) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'cod',
  `hash` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'hash',
  `title` varchar(250) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Titulo',
  `file` varchar(250) COLLATE utf8_unicode_ci NOT NULL COMMENT 'File',
  `arquivo` char(36) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Arquivo',
  `ext` varchar(4) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Extensao',
  `data_criacao` datetime DEFAULT NULL COMMENT 'Data criação',
  `data_atualizacao` datetime DEFAULT NULL COMMENT 'Data atualização',
  `status` int(11) DEFAULT NULL COMMENT 'Status'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `geral_arquivo`
--

CREATE TABLE `geral_arquivo` (
  `id` int(11) NOT NULL,
  `cod` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `local` int(11) DEFAULT NULL,
  `titulo` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `arquivo` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `data_criacao` datetime DEFAULT NULL,
  `data_atualizacao` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `geral_contato`
--

CREATE TABLE `geral_contato` (
  `id` int(11) NOT NULL,
  `cod` char(36) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Cod',
  `tabela` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Tabela',
  `contato` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Nome',
  `local` int(11) NOT NULL COMMENT 'Local',
  `tipo` int(11) NOT NULL COMMENT 'Tipo de contato',
  `outro` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Outro',
  `nome` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Nome',
  `documento` bigint(11) UNSIGNED ZEROFILL DEFAULT NULL,
  `valor` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Valor',
  `operadora` int(11) DEFAULT NULL COMMENT 'Operadora',
  `destaque` int(11) DEFAULT NULL COMMENT 'Destaque'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `geral_endereco`
--

CREATE TABLE `geral_endereco` (
  `id` int(11) NOT NULL,
  `cod` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tabela` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `local` int(11) NOT NULL,
  `nome` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Nome',
  `cep` int(8) NOT NULL COMMENT 'CEP',
  `logradouro` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Logradouro',
  `complemento` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Complemento',
  `referencia` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Referência',
  `numero` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Número',
  `bairro` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Bairro',
  `cidade` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Cidade',
  `estado` char(2) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Estado',
  `latitude` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Latitude',
  `longitude` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Longitude',
  `principal` int(11) DEFAULT NULL,
  `data_criacao` datetime DEFAULT NULL,
  `data_atualizacao` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `geral_foto`
--

CREATE TABLE `geral_foto` (
  `id` int(11) NOT NULL COMMENT 'Id',
  `cod` char(32) NOT NULL COMMENT 'Cod',
  `vinculo` char(32) NOT NULL,
  `imagem` char(36) NOT NULL COMMENT 'Estatuto',
  `foto_titulo` varchar(255) DEFAULT NULL COMMENT 'Titulo',
  `data_criacao` datetime NOT NULL COMMENT 'Data de criacao',
  `data_atualizacao` datetime DEFAULT NULL COMMENT 'Data de atualizacao',
  `destaque` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL COMMENT 'Status'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `geral_historico`
--

CREATE TABLE `geral_historico` (
  `id` int(11) NOT NULL,
  `cod` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `equipe` int(11) NOT NULL,
  `tabela` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `tipo` int(11) NOT NULL,
  `texto` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT 'Mensagem',
  `booleano` int(11) DEFAULT NULL,
  `data_criacao` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `mensagem_contato`
--

CREATE TABLE `mensagem_contato` (
  `id` int(11) NOT NULL,
  `cod` char(36) NOT NULL,
  `nome` varchar(255) NOT NULL COMMENT 'Nome',
  `telefone` text NOT NULL COMMENT 'telefone->Telefone',
  `email` varchar(255) NOT NULL COMMENT 'email->E-mail',
  `texto` text NOT NULL COMMENT 'Mensagem',
  `data_criacao` datetime NOT NULL COMMENT 'Data de criacao',
  `data_atualizacao` datetime DEFAULT NULL COMMENT 'Data de atualizacao',
  `status` int(11) NOT NULL COMMENT 'Status'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `multimidia_album`
--

CREATE TABLE `multimidia_album` (
  `id` int(11) NOT NULL,
  `cod` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `titulo` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `texto` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `data_postagem_inicio` date DEFAULT NULL,
  `data_postagem_atualizacao` datetime DEFAULT NULL,
  `data_criacao` datetime NOT NULL,
  `data_atualizacao` datetime DEFAULT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `multimidia_video`
--

CREATE TABLE `multimidia_video` (
  `id` int(11) NOT NULL,
  `cod` char(36) COLLATE utf8_unicode_ci NOT NULL,
  `titulo` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Chamada',
  `texto` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Texto pequeno',
  `chamada` text COLLATE utf8_unicode_ci NOT NULL COMMENT 'Chamada',
  `video` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Vídeo',
  `url` varchar(250) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Título principal',
  `data_criacao` datetime DEFAULT NULL,
  `data_atualizacao` datetime DEFAULT NULL,
  `data_postagem_inicio` datetime NOT NULL COMMENT 'Data da postagem',
  `data_postagem_final` datetime DEFAULT NULL COMMENT 'Data atualização',
  `data_postagem_atualizacao` datetime DEFAULT NULL,
  `destaque` int(11) NOT NULL COMMENT 'Destaque',
  `status` int(11) NOT NULL COMMENT 'Status'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `publicidade_banner`
--

CREATE TABLE `publicidade_banner` (
  `id` int(11) NOT NULL,
  `cod` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `titulo` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Título',
  `texto` text COLLATE utf8mb4_unicode_ci COMMENT 'Texto',
  `tipo` int(11) DEFAULT NULL,
  `link` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Link do site',
  `target` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `imagem` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Imagem',
  `data_postagem_inicio` datetime DEFAULT NULL,
  `data_postagem_final` datetime DEFAULT NULL,
  `data_criacao` datetime DEFAULT NULL,
  `data_atualizacao` datetime DEFAULT NULL,
  `ordem` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL COMMENT 'Status'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario_cliente`
--

CREATE TABLE `usuario_cliente` (
  `id` int(11) NOT NULL,
  `cod` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nome` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Nome',
  `documento` bigint(11) UNSIGNED ZEROFILL NOT NULL COMMENT 'cpf->CPF',
  `email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'email->E-mail',
  `telefone` bigint(11) DEFAULT NULL COMMENT 'telefone->Telefone',
  `celular` bigint(11) DEFAULT NULL COMMENT 'celular->Celular',
  `salt` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Senha',
  `cep` int(8) DEFAULT NULL COMMENT 'cep->CEP',
  `logradouro` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Logradouro',
  `numero` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Número',
  `complemento` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Complemento',
  `bairro` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Bairro',
  `cidade` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Cidade',
  `estado` char(2) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Estado',
  `hash` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `data_ativacao` datetime DEFAULT NULL,
  `data_nascimento` date DEFAULT NULL COMMENT 'Data de nascimento',
  `data_admissao` date DEFAULT NULL,
  `data_criacao` datetime DEFAULT NULL,
  `data_atualizacao` datetime DEFAULT NULL,
  `data_acesso` datetime DEFAULT NULL,
  `data_senha` datetime DEFAULT NULL,
  `primeiro_acesso` int(11) DEFAULT NULL,
  `termo_uso` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL COMMENT 'Status'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario_equipe`
--

CREATE TABLE `usuario_equipe` (
  `id` int(11) NOT NULL,
  `cod` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `empresa` int(11) DEFAULT NULL COMMENT 'Empresa',
  `facebook` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `google` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tipo` int(11) DEFAULT NULL,
  `area` int(11) DEFAULT NULL COMMENT 'Área',
  `ramal_numero` int(4) DEFAULT NULL,
  `ramal_id` int(4) DEFAULT NULL,
  `nome` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Nome',
  `documento` bigint(11) UNSIGNED ZEROFILL DEFAULT NULL COMMENT 'cpf->CPF',
  `sexo` int(11) DEFAULT NULL COMMENT 'Sexo',
  `aniversario` date DEFAULT NULL COMMENT 'data->Aniversario',
  `imagem` text COLLATE utf8mb4_unicode_ci COMMENT 'Imagem',
  `login` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'E-mail',
  `salt` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Senha',
  `data_criacao` datetime NOT NULL,
  `data_atualizacao` datetime DEFAULT NULL,
  `data_acesso` datetime DEFAULT NULL,
  `permissao` text COLLATE utf8mb4_unicode_ci COMMENT 'json->Permissão',
  `equipe` text COLLATE utf8mb4_unicode_ci COMMENT 'json->Equipe',
  `gerente` int(11) NOT NULL DEFAULT '2' COMMENT 'Gerente',
  `admin` int(11) DEFAULT '2' COMMENT 'Administrador',
  `mudar_senha` int(11) DEFAULT NULL,
  `desenvolvedor` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL COMMENT 'Status'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `usuario_equipe`
--

INSERT INTO `usuario_equipe` (`id`, `cod`, `empresa`, `facebook`, `google`, `tipo`, `area`, `ramal_numero`, `ramal_id`, `nome`, `documento`, `sexo`, `aniversario`, `imagem`, `login`, `salt`, `data_criacao`, `data_atualizacao`, `data_acesso`, `permissao`, `equipe`, `gerente`, `admin`, `mudar_senha`, `desenvolvedor`, `status`) VALUES
(1, '8d73d68ae46a6ecb0a2e9c4b5d8cdaed', 1, NULL, NULL, 1, NULL, NULL, NULL, 'Admin', 01234567890, NULL, '1987-07-27', NULL, 'admin', '$2y$11$S6j7R4KCVw5K/vup099yZedoy3f6k43udK7XsbaK/13PFi2LbtgUW', '2018-06-07 15:13:34', '2021-09-03 09:11:34', '2021-09-03 14:55:19', '[\"per_drive\",\"per_drive_visualizar\",\"per_drive_add\",\"per_drive_editar\",\"per_drive_deletar\",\"per_publicidade_banner_visualizar\",\"per_publicidade_banner_detalhe\",\"per_publicidade_banner_add\",\"per_publicidade_banner_editar\",\"per_publicidade_banner_deletar\",\"per_administrativo_status_visualizar\",\"per_administrativo_status_add\",\"per_administrativo_status_editar\",\"per_administrativo_status_deletar\",\"per_usuario_equipe_visualizar\",\"per_usuario_equipe_detalhe\",\"per_usuario_equipe_add\",\"per_usuario_equipe_editar\",\"per_usuario_equipe_deletar\",\"per_usuario_usuario_visualizar\",\"per_usuario_usuario_detalhe\",\"per_usuario_usuario_add\",\"per_usuario_usuario_editar\",\"per_usuario_usuario_deletar\",\"per_usuario_usuario_download\"]', NULL, 1, 1, 2, 2, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_status`
--
ALTER TABLE `admin_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `data_log`
--
ALTER TABLE `data_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `drive`
--
ALTER TABLE `drive`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `geral_arquivo`
--
ALTER TABLE `geral_arquivo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `geral_contato`
--
ALTER TABLE `geral_contato`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `geral_endereco`
--
ALTER TABLE `geral_endereco`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `geral_foto`
--
ALTER TABLE `geral_foto`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `geral_historico`
--
ALTER TABLE `geral_historico`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mensagem_contato`
--
ALTER TABLE `mensagem_contato`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `multimidia_album`
--
ALTER TABLE `multimidia_album`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `multimidia_video`
--
ALTER TABLE `multimidia_video`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `publicidade_banner`
--
ALTER TABLE `publicidade_banner`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `usuario_cliente`
--
ALTER TABLE `usuario_cliente`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `usuario_equipe`
--
ALTER TABLE `usuario_equipe`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_status`
--
ALTER TABLE `admin_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `data_log`
--
ALTER TABLE `data_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `drive`
--
ALTER TABLE `drive`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `geral_arquivo`
--
ALTER TABLE `geral_arquivo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `geral_contato`
--
ALTER TABLE `geral_contato`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `geral_endereco`
--
ALTER TABLE `geral_endereco`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `geral_foto`
--
ALTER TABLE `geral_foto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Id';

--
-- AUTO_INCREMENT for table `geral_historico`
--
ALTER TABLE `geral_historico`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mensagem_contato`
--
ALTER TABLE `mensagem_contato`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `multimidia_album`
--
ALTER TABLE `multimidia_album`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `multimidia_video`
--
ALTER TABLE `multimidia_video`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `publicidade_banner`
--
ALTER TABLE `publicidade_banner`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `usuario_cliente`
--
ALTER TABLE `usuario_cliente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `usuario_equipe`
--
ALTER TABLE `usuario_equipe`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
