# Inserindo os dados

```sql
INSERT INTO usuarios(nome, email, senha, data_nascimento, tipo)
VALUES(
    'joão pedro',
    'joaopedro18231@hotmail.com',
    '1234567tigre',
    '1997-01-26',
    'admin'
),
(
    'Carlos Eduardo Lima',
    'carlos.lima@email.com',
    'CarLima#89',
    '1989-11-28',
    'padrão'
),
(
    'Júlia Mendes Rocha',
    'julia.rocha@email.com',
    'JuRo@2023',
    '1995-07-05',
    'padrão'
),
(
    'Roberto da Silva Neto',
    'roberto.silva@email.com',
    'RobSilv@12',
    '1985-02-19',
    'padrão'
),
(
    'Mariana Costa Andrade',
    'mariana.andrade@email.com',
    'MarAnd#33',
    '1993-09-23',
    'padrão'
);
```

```sql
INSERT INTO generos(nome)
VALUES(
    'comédia'
),
(
    'ação'
),
(
    'aventura'
),
(
    'animação'
),
(
    'fantasia'
),
(
    'ficção científica'
),
(
    'drama'
),
(
    'suspense'
),
(
    'Terror'
),
(
    'romance'
);
```

```sql
INSERT INTO plataformas(nome)
VALUES(
    'Disney+'
),
( 
    'Prime Video'
),
( 
    'Max'
),
( 
    'MUBI'
), 
(   
    'Netflix'
),
( 
    'Amazon'
),
(  
    'Kindle'
),
(
    'Kobo'
);
```

```sql
INSERT INTO filmes(titulo, diretor, data_lancamento, duracao, classificacao, descricao, poster_url, usuario_id, genero_id)
VALUES(
    'Divertida Mente 2',
    'Kelsey Mann',
    '2024-06-20',
    96,
    'Livre',
    'Em Divertida Mente 2, a história continua acompanhando as emoções que vivem dentro da cabeça de uma jovem.',
    'https://www.themoviedb.org/t/p/w600_and_h900_bestv2/xGvz7nlGQeePcVOpAzOcHsC7kRt.jpg',
    5,
    4
),
(
    'Deadpool & Wolverine',
    'David Leitch',
    '2018-05-18',
    119,
    '18 anos',
    'Wade Wilson, o Deadpool, volta para uma nova jornada ao lado de uma equipe de mutantes.',
    'https://www.themoviedb.org/t/p/w600_and_h900_bestv2/xq4v7JE8niZ75OYYPDGNn6Gzpyt.jpg',
    2,
    2
),
(
    'Moana 2',
    ' Dana Ledoux Miller',
    '2024-11-28',
    100,
    'Livre',
    'Em "Moana 2", Moana e Maui se reúnem para uma nova jornada pelos mares após um chamado de seus ancestrais.',
    'https://br.web.img2.acsta.net/c_600_900/img/fb/8a/fb8a2dd78cc344d9b2fdf5e0a4bb4026.jpeg',
    3,
    4
),
(
    'Meu Malvado Favorito 4',
    'Kyle Balda',
    '2022-07-01',
    87,
    'Livre',
    'O filme é uma continuação da saga Meu Malvado Favorito, focando no crescimento do jovem Gru.',
    'https://image.tmdb.org/t/p/w600_and_h900_face/jWYTtmxSuWVXP22hxAeXdQZLZrh.jpg',
    4,
    4
),
(
    'Mufasa: O Rei Leão',
    'Barry Jenkins',
    '2024-12-19',
    118,
    '10 anos',
    'Em Mufasa: O Rei Leão, Rafiki narra a história de Mufasa à jovem Kiara, filha de Simba e Nala.',
    'https://www.themoviedb.org/t/p/w600_and_h900_bestv2/iMVuv6Gz5fj7vZ51IjRF3AiW87y.jpg',
    5,
    4
),
(
    'Duna 2',
    'Denis Villeneuve',
    '2024-02-29',
    166,
    '14 anos',
    'Em Duna: Parte 2, Paul Atreides (Timothée Chalamet) se une a Chani (Zendaya) e aos Fremen em uma jornada de vingança contra os conspiradores que destruíram sua família.',
    'https://www.themoviedb.org/t/p/w600_and_h900_bestv2/8LJJjLjAzAwXS40S5mx79PJ2jSs.jpg',
    2,
    6
),
(
    'Sonic 3: O Filme',
    'Jeff Fowler',
    '2024-12-25',
    110,
    '12 anos',
    'Sonic, Knuckles e Tails reúnem-se contra um novo e poderoso adversário, Shadow, um vilão misterioso com poderes diferentes de tudo o que alguma vez tiveram de enfrentar.',
    'https://www.themoviedb.org/t/p/w600_and_h900_bestv2/tfM1T6tAivjvy0sLwt6Y9WvlmzB.jpg',
    12,
    6
)
(
    'Venom: A Última Dança',
    'Kelly Marcel',
    '2024-10-24',
    110,
    '14 anos',
    'Eddie e Venom estão em fuga. Perseguidos pelos seus dois mundos e com o cerco a apertar, a dupla é forçada a tomar uma decisão devastadora que resultará na última dança de ambos.',
    'https://www.themoviedb.org/t/p/w600_and_h900_bestv2/p8CHaGudwUzBSU7dTjzMd71Iv4M.jpg',
    12,
    2
),
```

```sql
INSERT INTO livros(titulo, autor, data_lancamento, faixa_etaria, descricao, imagem_capa_url, usuario_id, genero_id)
VALUES(
    'Nem Te Conto',
    'Emily Henry',
    '2024-04-23',
    'Adulto',
    'Em Nem te conto, Daphne vê sua vida virar de cabeça para baixo quando seu noivo, Peter, se apaixona por sua melhor amiga de infância, Petra',
    'https://m.media-amazon.com/images/I/71qp8YwAt3L._SL1500_.jpg',
    1,
    10
),
(
    'A Primeira Mentira',
    'Ashley Elston',
    '2024-10-02',
    'Juvenil',
    'A Primeira Mentira é o primeiro thriller adulto de Ashley Elston, autora anteriormente conhecida por suas obras para o público jovem adulto',
    'https://m.media-amazon.com/images/I/811qQCoJQiL._SL1500_.jpg',
    1,
    8
),
(
    'Até o fim do verão',
    'Abby Jimenez',
    '2025-05-06',
    'Adulto',
    'Justin acredita que está amaldiçoado: sempre que um relacionamento termina, sua ex-namorada encontra o amor da sua vida logo depois.',
    'https://m.media-amazon.com/images/I/81LcML07DAL._SL1500_.jpg',
    2,
    10
),
(
    'Como Arruinar um Casamento',
    'Alison Espach',
    '2025-05-01',
    'Adulto',
    'Em "Como arruinar um casamento," de Alison Espach, embarque em uma jornada surpreendente e profundamente sábia que começa com uma chegada inesperada.',
    'https://m.media-amazon.com/images/I/71z5QR-Ov4L._SL1500_.jpg',
    2,
    10
),
(
    'A Professora',
    'Freida McFadden',
    '2024-10-28',
    'Adulto',
    'Todos dizem que Eve tem uma vida boa. Ela tem um emprego estável, uma bela casa, um marido lindo... Tudo parece perfeito, como deveria ser. Mas nem tudo é como Eve gostaria que fosse.',
    'https://m.media-amazon.com/images/I/81Lyq240udL._SL1500_.jpg',
    3,
    8
),
(
    'Casa de Chama e Sombra',
    'Sarah J. Maas',
    '2024-01-30',
    'Adulto',
    'Por essa Bryce Quinlan realmente não esperava. Ela nunca imaginou que fosse sair de Midgard, mas os malditos asteri a forçaram a literalmente procurar pelas portas do Inferno.',
    'https://m.media-amazon.com/images/I/91cdzhQQwEL._SL1500_.jpg',
    3,
    5
),
(
    'Filhos de Aflição e Anarquia',
    'Tomi Adeyemi',
    '2024-09-27',
    'Adulto',
    'Quando Zélie tomou o palácio real naquela noite fatídica, ela pensou que suas batalhas haviam chegado ao fim.',
    'https://m.media-amazon.com/images/I/91crvEm6SwL._SL1500_.jpg',
    5,
    5
),
(
    'Dom Quixote',
    'Miguel de Cervantes',
    '2023-09-25',
    'Adulto',
    'Dom Quixote, escrito pelo espanhol Miguel de Cervantes, é umclássico da literatura mundial e uma das obras mais influentesda história.',
    'https://m.media-amazon.com/images/I/716YWt8LnCL._SL1419_.jpg',
    12,
    10
);
```

```sql
INSERT INTO filmes_favoritos(usuario_id, filme_id)
VALUES(
    5,
    1
),
(
    2,
    2
),
(
    3,
    3
),
(
    4,
    4
),
(
    5,
    5
),
(
    2,
    6
),
(
    1,
    7
);
```

```sql
INSERT INTO livros_favoritos(usuario_id, livro_id)
VALUES(
    1,
    1
),
(
    1,
    2
),
(
    2,
    3
),
(
    2,
    4
),
(
    3,
    5
),
(
    3,
    6
),
(
    5,
    7
);
```

```sql
INSERT INTO filmes_plataformas(filme_id, plataforma_id)
VALUES(
    1,
    1
),
(
    2,
    1
),
(
    3,
    1
),
(
    4,
    2
),
(
    5,
    1
),
(
    6,
    2
),
(
    7,
    3
);
```

```sql
INSERT INTO livros_plataformas(livro_id, plataforma_id)
VALUES(
    1,
    7
),
(
    2,
    7
),
(
    3,
    8
),
(
    4,
    7
),
(
    5,
    7
),
(
    6,
    6
),
(
    7,
    8
);
```

# Comandos CRUD para Consultas

```sql
SELECT titulo, data_lancamento, classificacao 
FROM filmes
WHERE YEAR(data_lancamento) = 2024
ORDER BY titulo ASC;
```

```sql
SELECT titulo, data_lancamento, classificacao 
FROM filmes
WHERE classificacao = 'Livre'
ORDER BY titulo ASC;
```

```sql
SELECT titulo, data_lancamento, duracao, classificacao 
FROM filmes
WHERE duracao > 100
ORDER BY titulo ASC;
```

```sql
SELECT 
  usuarios.nome AS nome_do_usuario,
  filmes.titulo AS nome_do_filme,
  filmes.duracao AS duracao_do_filme
FROM usuarios
JOIN filmes ON usuarios.id = filmes.usuario_id
ORDER BY usuarios.nome;
```

```sql
SELECT titulo, autor, data_lancamento
FROM livros
WHERE YEAR(data_lancamento) = 2025
ORDER BY titulo ASC;
```

```sql
SELECT titulo, autor, faixa_etaria
FROM livros
WHERE faixa_etaria = 'Adulto'
ORDER BY titulo ASC;
```

```sql
SELECT
  usuarios.nome AS nome_do_usuario,
  livros.titulo AS nome_do_livro,
  livros.data_lancamento AS data_de_lancamento
  FROM usuarios
  JOIN livros ON usuarios.id = livros.usuario_id
  ORDER BY usuarios.nome;
```