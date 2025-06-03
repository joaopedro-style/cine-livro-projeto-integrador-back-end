-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 06/05/2025 às 17:17
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
(1, 'Divertida Mente 2', 'Kelsey Mann', '2024-06-20', 96, 'Livre', 'Em Divertida Mente 2, a história continua acompanhando as emoções que vivem dentro da cabeça de uma jovem.', 'https://www.themoviedb.org/t/p/w600_and_h900_bestv2/xGvz7nlGQeePcVOpAzOcHsC7kRt.jpg', 5, 4),
(2, 'Deadpool & Wolverine', 'David Leitch', '2018-05-18', 119, '18 anos', 'Wade Wilson, o Deadpool, volta para uma nova jornada ao lado de uma equipe de mutantes.', 'https://www.themoviedb.org/t/p/w600_and_h900_bestv2/xq4v7JE8niZ75OYYPDGNn6Gzpyt.jpg', 2, 2),
(3, 'Moana 2', ' Dana Ledoux Miller', '2024-11-28', 100, 'Livre', 'Em \"Moana 2\", Moana e Maui se reúnem para uma nova jornada pelos mares após um chamado de seus ancestrais.', 'https://br.web.img2.acsta.net/c_600_900/img/fb/8a/fb8a2dd78cc344d9b2fdf5e0a4bb4026.jpeg', 3, 4),
(4, 'Meu Malvado Favorito 4', 'Kyle Balda', '2022-07-01', 87, 'Livre', 'O filme é uma continuação da saga Meu Malvado Favorito, focando no crescimento do jovem Gru.', 'https://image.tmdb.org/t/p/w600_and_h900_face/jWYTtmxSuWVXP22hxAeXdQZLZrh.jpg', 4, 4),
(5, 'Mufasa: O Rei Leão', 'Barry Jenkins', '2024-12-19', 118, '10 anos', 'Em Mufasa: O Rei Leão, Rafiki narra a história de Mufasa à jovem Kiara, filha de Simba e Nala.', 'https://www.themoviedb.org/t/p/w600_and_h900_bestv2/iMVuv6Gz5fj7vZ51IjRF3AiW87y.jpg', 5, 4),
(6, 'Duna 2', 'Denis Villeneuve', '2024-02-29', 166, '14 anos', 'Em Duna: Parte 2, Paul Atreides (Timothée Chalamet) se une a Chani (Zendaya) e aos Fremen em uma jornada de vingança contra os conspiradores que destruíram sua família.', 'https://www.themoviedb.org/t/p/w600_and_h900_bestv2/8LJJjLjAzAwXS40S5mx79PJ2jSs.jpg', 2, 6),
(7, 'Godzilla e Kong: O Novo Império', 'Adam Wingard', '2024-07-04', 115, '12 anos', 'Após os eventos de Godzilla vs. Kong (2021), os dois titãs devem unir forças para enfrentar uma nova ameaça colossal oculta no mundo subterrâneo.', 'https://www.themoviedb.org/t/p/w600_and_h900_bestv2/fWSGD2yrzz6hscocnMD8AEXIThk.jpg', 1, 6);

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
(1, 5, 1),
(2, 2, 2),
(3, 3, 3),
(4, 4, 4),
(5, 5, 5),
(6, 2, 6),
(7, 1, 7);

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
(1, 1, 1),
(2, 2, 1),
(3, 3, 1),
(4, 4, 2),
(5, 5, 1),
(6, 6, 2),
(7, 7, 3);

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
(1, 'Nem Te Conto', 'Emily Henry', '2024-04-23', 'Adulto', 'Em Nem te conto, Daphne vê sua vida virar de cabeça para baixo quando seu noivo, Peter, se apaixona por sua melhor amiga de infância, Petra', 'https://m.media-amazon.com/images/I/71qp8YwAt3L._SL1500_.jpg', 1, 10),
(2, 'A Primeira Mentira', 'Ashley Elston', '2024-10-02', 'Juvenil', 'A Primeira Mentira é o primeiro thriller adulto de Ashley Elston, autora anteriormente conhecida por suas obras para o público jovem adulto', 'https://m.media-amazon.com/images/I/811qQCoJQiL._SL1500_.jpg', 1, 8),
(3, 'Até o fim do verão', 'Abby Jimenez', '2025-05-06', 'Adulto', 'Justin acredita que está amaldiçoado: sempre que um relacionamento termina, sua ex-namorada encontra o amor da sua vida logo depois.', 'https://m.media-amazon.com/images/I/81LcML07DAL._SL1500_.jpg', 2, 10),
(4, 'Como Arruinar um Casamento', 'Alison Espach', '2025-05-01', 'Adulto', 'Em \"Como arruinar um casamento,\" de Alison Espach, embarque em uma jornada surpreendente e profundamente sábia que começa com uma chegada inesperada.', 'https://m.media-amazon.com/images/I/71z5QR-Ov4L._SL1500_.jpg', 2, 10),
(5, 'A Professora', 'Freida McFadden', '2024-10-28', 'Adulto', 'Todos dizem que Eve tem uma vida boa. Ela tem um emprego estável, uma bela casa, um marido lindo... Tudo parece perfeito, como deveria ser. Mas nem tudo é como Eve gostaria que fosse.', 'https://m.media-amazon.com/images/I/81Lyq240udL._SL1500_.jpg', 3, 8),
(6, 'Casa de Chama e Sombra', 'Sarah J. Maas', '2024-01-30', 'Adulto', 'Por essa Bryce Quinlan realmente não esperava. Ela nunca imaginou que fosse sair de Midgard, mas os malditos asteri a forçaram a literalmente procurar pelas portas do Inferno.', 'https://m.media-amazon.com/images/I/91cdzhQQwEL._SL1500_.jpg', 3, 5),
(7, 'Filhos de Aflição e Anarquia', 'Tomi Adeyemi', '2024-09-27', 'Adulto', 'Quando Zélie tomou o palácio real naquela noite fatídica, ela pensou que suas batalhas haviam chegado ao fim.', 'https://m.media-amazon.com/images/I/91crvEm6SwL._SL1500_.jpg', 5, 5);

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
(1, 1, 1),
(2, 1, 2),
(3, 2, 3),
(4, 2, 4),
(5, 3, 5),
(6, 3, 6),
(7, 5, 7);

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
(1, 1, 7),
(2, 2, 7),
(3, 3, 8),
(4, 4, 7),
(5, 5, 7),
(6, 6, 6),
(7, 7, 8);

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
  `data_nascimento` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `email`, `senha`, `data_nascimento`) VALUES
(1, 'Ana Paula Ferreira', 'ana.ferreira@email.com', 'AnaP@2025', '1990-03-12'),
(2, 'Carlos Eduardo Lima', 'carlos.lima@email.com', 'CarLima#89', '1989-11-28'),
(3, 'Júlia Mendes Rocha', 'julia.rocha@email.com', 'JuRo@2023', '1995-07-05'),
(4, 'Roberto da Silva Neto', 'roberto.silva@email.com', 'RobSilv@12', '1985-02-19'),
(5, 'Mariana Costa Andrade', 'mariana.andrade@email.com', 'MarAnd#33', '1993-09-23');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `filmes_favoritos`
--
ALTER TABLE `filmes_favoritos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `filmes_plataformas`
--
ALTER TABLE `filmes_plataformas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `generos`
--
ALTER TABLE `generos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `livros`
--
ALTER TABLE `livros`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `livros_favoritos`
--
ALTER TABLE `livros_favoritos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `livros_plataformas`
--
ALTER TABLE `livros_plataformas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `plataformas`
--
ALTER TABLE `plataformas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
