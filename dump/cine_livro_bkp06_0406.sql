-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 05/06/2025 às 02:46
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
-- Banco de dados: `cine_livro`
--
CREATE DATABASE IF NOT EXISTS `cine_livro` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `cine_livro`;

-- --------------------------------------------------------

--
-- Estrutura para tabela `filmes`
--

CREATE TABLE `filmes` (
  `id` int(11) NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `diretor` varchar(100) NOT NULL,
  `data_lancamento` date NOT NULL,
  `duracao` smallint(6) NOT NULL,
  `classificacao` enum('Livre','10 anos','12 anos','14 anos','16 anos','18 anos') NOT NULL,
  `descricao` text NOT NULL,
  `poster_url` varchar(255) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `genero_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `filmes`
--

INSERT INTO `filmes` (`id`, `titulo`, `diretor`, `data_lancamento`, `duracao`, `classificacao`, `descricao`, `poster_url`, `usuario_id`, `genero_id`) VALUES
(14, 'Divertida Mente 2', 'Kelsey Mann', '2024-06-20', 96, 'Livre', 'Em Divertida Mente 2, a história continua acompanhando as emoções que vivem dentro da cabeça de uma jovem.', 'https://www.themoviedb.org/t/p/w600_and_h900_bestv2/xGvz7nlGQeePcVOpAzOcHsC7kRt.jpg', 12, 4),
(15, 'Deadpool & Wolverine', 'David Leitch', '2024-07-25', 119, '18 anos', 'Wade Wilson, o Deadpool, volta para uma nova jornada ao lado de uma equipe de mutantes.', 'https://www.themoviedb.org/t/p/w600_and_h900_bestv2/xq4v7JE8niZ75OYYPDGNn6Gzpyt.jpg', 12, 2),
(16, 'Moana 2', 'Dana Ledoux Miller', '2024-11-28', 100, 'Livre', 'Em Moana 2, Moana e Maui se reúnem para uma nova jornada pelos mares após um chamado de seus ancestrais.', 'https://br.web.img2.acsta.net/c_600_900/img/fb/8a/fb8a2dd78cc344d9b2fdf5e0a4bb4026.jpeg', 12, 4),
(17, 'Meu Malvado Favorito 4', 'Kyle Balda', '2024-07-04', 87, 'Livre', 'O filme é uma continuação da saga Meu Malvado Favorito, focando no crescimento do jovem Gru.', 'https://image.tmdb.org/t/p/w600_and_h900_face/jWYTtmxSuWVXP22hxAeXdQZLZrh.jpg', 12, 4),
(18, 'Mufasa: O Rei Leão', 'Barry Jenkins', '2024-12-19', 118, '10 anos', 'Em Mufasa: O Rei Leão, Rafiki narra a história de Mufasa à jovem Kiara, filha de Simba e Nala.', 'https://www.themoviedb.org/t/p/w600_and_h900_bestv2/iMVuv6Gz5fj7vZ51IjRF3AiW87y.jpg', 12, 4),
(19, 'Duna 2', 'Denis Villeneuve', '2024-02-29', 166, '14 anos', 'Em Duna: Parte 2, Paul Atreides (Timothée Chalamet) se une a Chani (Zendaya) e aos Fremen em uma jornada de vingança contra os conspiradores que destruíram sua família.', 'https://www.themoviedb.org/t/p/w600_and_h900_bestv2/8LJJjLjAzAwXS40S5mx79PJ2jSs.jpg', 12, 6),
(20, 'Sonic 3: O Filme', 'Jeff Fowler', '2024-12-25', 110, '12 anos', 'Sonic, Knuckles e Tails reúnem-se contra um novo e poderoso adversário, Shadow, um vilão misterioso com poderes diferentes de tudo o que alguma vez tiveram de enfrentar.', 'https://www.themoviedb.org/t/p/w600_and_h900_bestv2/tfM1T6tAivjvy0sLwt6Y9WvlmzB.jpg', 12, 6),
(21, 'Venom: A Última Dança', 'Kelly Marcel', '2024-10-24', 110, '14 anos', 'Eddie e Venom estão em fuga. Perseguidos pelos seus dois mundos e com o cerco a apertar, a dupla é forçada a tomar uma decisão devastadora que resultará na última dança de ambos.', 'https://www.themoviedb.org/t/p/w600_and_h900_bestv2/p8CHaGudwUzBSU7dTjzMd71Iv4M.jpg', 12, 2);

-- --------------------------------------------------------

--
-- Estrutura para tabela `filmes_favoritos`
--

CREATE TABLE `filmes_favoritos` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `filme_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `filmes_favoritos`
--

INSERT INTO `filmes_favoritos` (`id`, `usuario_id`, `filme_id`) VALUES
(25, 28, 21),
(26, 28, 19),
(27, 29, 18),
(28, 29, 17),
(29, 32, 14),
(30, 32, 16),
(31, 33, 15),
(32, 33, 20);

-- --------------------------------------------------------

--
-- Estrutura para tabela `filmes_plataformas`
--

CREATE TABLE `filmes_plataformas` (
  `id` int(11) NOT NULL,
  `filme_id` int(11) NOT NULL,
  `plataforma_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `filmes_plataformas`
--

INSERT INTO `filmes_plataformas` (`id`, `filme_id`, `plataforma_id`) VALUES
(11, 14, 1),
(12, 15, 1),
(13, 16, 1),
(14, 17, 2),
(15, 18, 1),
(16, 19, 3),
(17, 20, 2),
(18, 21, 2);

-- --------------------------------------------------------

--
-- Estrutura para tabela `generos`
--

CREATE TABLE `generos` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `generos`
--

INSERT INTO `generos` (`id`, `nome`) VALUES
(1, 'comédia'),
(2, 'ação'),
(3, 'aventura'),
(4, 'animação'),
(5, 'fantasia'),
(6, 'ficção científica'),
(7, 'drama'),
(8, 'suspense'),
(9, 'Terror'),
(10, 'romance');

-- --------------------------------------------------------

--
-- Estrutura para tabela `livros`
--

CREATE TABLE `livros` (
  `id` int(11) NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `autor` varchar(100) NOT NULL,
  `data_lancamento` date NOT NULL,
  `faixa_etaria` enum('Infantil','Infantojuvenil','Juvenil','Adulto') NOT NULL,
  `descricao` text NOT NULL,
  `imagem_capa_url` varchar(255) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `genero_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `livros`
--

INSERT INTO `livros` (`id`, `titulo`, `autor`, `data_lancamento`, `faixa_etaria`, `descricao`, `imagem_capa_url`, `usuario_id`, `genero_id`) VALUES
(13, 'Nem Te Conto', 'Emily Henry', '2024-04-23', 'Adulto', 'Em Nem te conto, Daphne vê sua vida virar de cabeça para baixo quando seu noivo, Peter, se apaixona por sua melhor amiga de infância, Petra.', 'https://m.media-amazon.com/images/I/71qp8YwAt3L._SL1500_.jpg', 12, 10),
(14, 'A Primeira Mentira', 'Ashley Elston', '2024-10-02', 'Juvenil', 'A Primeira Mentira é o primeiro thriller adulto de Ashley Elston, autora anteriormente conhecida por suas obras para o público jovem adulto.', 'https://m.media-amazon.com/images/I/811qQCoJQiL._SL1500_.jpg', 12, 8),
(15, 'Até o fim do verão', 'Abby Jimenez', '2025-05-06', 'Adulto', 'Justin acredita que está amaldiçoado: sempre que um relacionamento termina, sua ex-namorada encontra o amor da sua vida logo depois.', 'https://m.media-amazon.com/images/I/81LcML07DAL._SL1500_.jpg', 12, 10),
(16, 'Como Arruinar um Casamento', 'Alison Espach', '2025-05-01', 'Adulto', 'Em Como arruinar um casamento, de Alison Espach, embarque em uma jornada surpreendente e profundamente sábia que começa com uma chegada inesperada.', 'https://m.media-amazon.com/images/I/71z5QR-Ov4L._SL1500_.jpg', 12, 10),
(17, 'A Professora', 'Freida McFadden', '2024-10-28', 'Adulto', 'Todos dizem que Eve tem uma vida boa. Ela tem um emprego estável, uma bela casa, um marido lindo... Tudo parece perfeito, como deveria ser. Mas nem tudo é como Eve gostaria que fosse.', 'https://m.media-amazon.com/images/I/81Lyq240udL._SL1500_.jpg', 12, 8),
(18, 'Casa de Chama e Sombra', 'Sarah J. Maas', '2024-01-30', 'Adulto', 'Por essa Bryce Quinlan realmente não esperava. Ela nunca imaginou que fosse sair de Midgard, mas os malditos asteri a forçaram a literalmente procurar pelas portas do Inferno.', 'https://m.media-amazon.com/images/I/91cdzhQQwEL._SL1500_.jpg', 12, 5),
(19, 'Filhos de Aflição e Anarquia', 'Tomi Adeyemi', '2024-09-27', 'Adulto', 'Quando Zélie tomou o palácio real naquela noite fatídica, ela pensou que suas batalhas haviam chegado ao fim.', 'https://m.media-amazon.com/images/I/91crvEm6SwL._SL1500_.jpg', 12, 5),
(20, 'Dom Quixote', 'Miguel de Cervantes', '2023-09-25', 'Adulto', 'Dom Quixote, escrito pelo espanhol Miguel de Cervantes, é umclássico da literatura mundial e uma das obras mais influentesda história.', 'https://m.media-amazon.com/images/I/716YWt8LnCL._SL1419_.jpg', 12, 10);

-- --------------------------------------------------------

--
-- Estrutura para tabela `livros_favoritos`
--

CREATE TABLE `livros_favoritos` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `livro_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `livros_favoritos`
--

INSERT INTO `livros_favoritos` (`id`, `usuario_id`, `livro_id`) VALUES
(17, 28, 17),
(18, 28, 20),
(19, 29, 14),
(21, 29, 13),
(22, 32, 15),
(23, 32, 13),
(24, 33, 18),
(25, 33, 19);

-- --------------------------------------------------------

--
-- Estrutura para tabela `livros_plataformas`
--

CREATE TABLE `livros_plataformas` (
  `id` int(11) NOT NULL,
  `livro_id` int(11) NOT NULL,
  `plataforma_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `livros_plataformas`
--

INSERT INTO `livros_plataformas` (`id`, `livro_id`, `plataforma_id`) VALUES
(9, 13, 7),
(10, 14, 6),
(11, 15, 7),
(12, 16, 7),
(13, 17, 6),
(14, 18, 7),
(15, 19, 7),
(16, 20, 7);

-- --------------------------------------------------------

--
-- Estrutura para tabela `plataformas`
--

CREATE TABLE `plataformas` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `plataformas`
--

INSERT INTO `plataformas` (`id`, `nome`) VALUES
(1, 'Disney+'),
(2, 'Prime Video'),
(3, 'Max'),
(4, 'MUBI'),
(5, 'Netflix'),
(6, 'Amazon'),
(7, 'Kindle'),
(8, 'Kobo');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `data_nascimento` date NOT NULL,
  `tipo` enum('admin','padrão') NOT NULL DEFAULT 'padrão'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `email`, `senha`, `data_nascimento`, `tipo`) VALUES
(12, 'joão pedro', 'joaopedro18231@hotmail.com', '$2y$10$pK3g41tqs79QrtsOqXHV/uCMltaTrWrMQcQ9AcoIkEfR0Ba3uIBOy', '1997-01-26', 'admin'),
(28, 'kaique', 'kaique777@hotmail.com', '$2y$10$vSUmnoHZEkvAwDCccUZLM.Ic7QM3SBCDLTgZDz1nHI9GaMcLLEy8C', '1997-07-27', 'padrão'),
(29, 'jose', 'josesantos@hotmail.com', '$2y$10$ZSgh4VcI/Ttkq8wioOTxTe41gK8o8oi.uTLos2cHpgUyJ4JGUAogK', '1995-07-27', 'padrão'),
(32, 'fatima', 'fatima@hotmail.com', '$2y$10$qkPD9I35L4hrPKVy6hg6JuwN2bjynzEf8WDr.9/cYXb1UicuMyu1.', '1967-04-08', 'padrão'),
(33, 'pedro', 'pedro@hotmail.com', '$2y$10$Ra6uzFjK0po/mJfCxsPGVO7mKH/dFwrMCtlHmjIQ20T31navP5b9m', '2003-08-25', 'padrão');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `filmes`
--
ALTER TABLE `filmes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `genero_id` (`genero_id`);

--
-- Índices de tabela `filmes_favoritos`
--
ALTER TABLE `filmes_favoritos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `filme_id` (`filme_id`);

--
-- Índices de tabela `filmes_plataformas`
--
ALTER TABLE `filmes_plataformas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `filme_id` (`filme_id`),
  ADD KEY `plataforma_id` (`plataforma_id`);

--
-- Índices de tabela `generos`
--
ALTER TABLE `generos`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `livros`
--
ALTER TABLE `livros`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `genero_id` (`genero_id`);

--
-- Índices de tabela `livros_favoritos`
--
ALTER TABLE `livros_favoritos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `livro_id` (`livro_id`);

--
-- Índices de tabela `livros_plataformas`
--
ALTER TABLE `livros_plataformas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `livro_id` (`livro_id`),
  ADD KEY `plataforma_id` (`plataforma_id`);

--
-- Índices de tabela `plataformas`
--
ALTER TABLE `plataformas`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT de tabela `filmes`
--
ALTER TABLE `filmes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de tabela `filmes_favoritos`
--
ALTER TABLE `filmes_favoritos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT de tabela `filmes_plataformas`
--
ALTER TABLE `filmes_plataformas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de tabela `generos`
--
ALTER TABLE `generos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de tabela `livros`
--
ALTER TABLE `livros`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de tabela `livros_favoritos`
--
ALTER TABLE `livros_favoritos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de tabela `livros_plataformas`
--
ALTER TABLE `livros_plataformas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de tabela `plataformas`
--
ALTER TABLE `plataformas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `filmes`
--
ALTER TABLE `filmes`
  ADD CONSTRAINT `filmes_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `filmes_ibfk_2` FOREIGN KEY (`genero_id`) REFERENCES `generos` (`id`);

--
-- Restrições para tabelas `filmes_favoritos`
--
ALTER TABLE `filmes_favoritos`
  ADD CONSTRAINT `filmes_favoritos_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `filmes_favoritos_ibfk_2` FOREIGN KEY (`filme_id`) REFERENCES `filmes` (`id`);

--
-- Restrições para tabelas `filmes_plataformas`
--
ALTER TABLE `filmes_plataformas`
  ADD CONSTRAINT `filmes_plataformas_ibfk_1` FOREIGN KEY (`filme_id`) REFERENCES `filmes` (`id`),
  ADD CONSTRAINT `filmes_plataformas_ibfk_2` FOREIGN KEY (`plataforma_id`) REFERENCES `plataformas` (`id`);

--
-- Restrições para tabelas `livros`
--
ALTER TABLE `livros`
  ADD CONSTRAINT `livros_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `livros_ibfk_2` FOREIGN KEY (`genero_id`) REFERENCES `generos` (`id`);

--
-- Restrições para tabelas `livros_favoritos`
--
ALTER TABLE `livros_favoritos`
  ADD CONSTRAINT `livros_favoritos_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `livros_favoritos_ibfk_2` FOREIGN KEY (`livro_id`) REFERENCES `livros` (`id`);

--
-- Restrições para tabelas `livros_plataformas`
--
ALTER TABLE `livros_plataformas`
  ADD CONSTRAINT `livros_plataformas_ibfk_1` FOREIGN KEY (`livro_id`) REFERENCES `livros` (`id`),
  ADD CONSTRAINT `livros_plataformas_ibfk_2` FOREIGN KEY (`plataforma_id`) REFERENCES `plataformas` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
