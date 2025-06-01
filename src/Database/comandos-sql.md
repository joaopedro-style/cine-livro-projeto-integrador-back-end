 # Criando o banco de dados

```sql
CREATE DATABASE cine_livro
CHARACTER SET utf8mb4;
```

```sql
CREATE TABLE generos (
  id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  nome VARCHAR(100) NOT NULL
);
```

```sql
CREATE TABLE plataformas (
  id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  nome VARCHAR(100) NOT NULL
);
```

```sql
CREATE TABLE usuarios (
  id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  nome VARCHAR(100) NOT NULL,
  email VARCHAR(100) NOT NULL UNIQUE,
  senha VARCHAR(255) NOT NULL, 
  data_nascimento DATE NOT NULL,
  tipo ENUM('admin', 'padrão') NOT NULL
);
```

```sql
CREATE TABLE filmes (
  id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  titulo VARCHAR(100) NOT NULL,
  diretor VARCHAR(100) NOT NULL,
  data_lancamento DATE NOT NULL,
  duracao SMALLINT NOT NULL,
  classificacao ENUM('Livre', '10 anos', '12 anos', '14 anos', '16 anos', '18 anos') NOT NULL,
  descricao TEXT NOT NULL,
  poster_url VARCHAR(255) NOT NULL,
  usuario_id INT NOT NULL,
  genero_id INT NOT NULL,
  FOREIGN KEY (usuario_id) REFERENCES usuarios(id),
  FOREIGN KEY (genero_id) REFERENCES generos(id)
);
```

```sql
CREATE TABLE livros (
  id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  titulo VARCHAR(100) NOT NULL,
  autor VARCHAR(100) NOT NULL,
  data_lancamento DATE NOT NULL,
  faixa_etaria ENUM('Infantil', 'Infantojuvenil', 'juvenil', 'Adulto') NOT NULL,
  descricao TEXT NOT NULL,
  imagem_capa_url VARCHAR(255) NOT NULL,
  usuario_id INT NOT NULL,
  genero_id INT NOT NULL,
  FOREIGN KEY (usuario_id) REFERENCES usuarios(id),
  FOREIGN KEY (genero_id) REFERENCES generos(id)
);
```

```sql
CREATE TABLE filmes_favoritos (
  id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  usuario_id INT NOT NULL,
  filme_id INT NOT NULL,
  FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
  FOREIGN KEY (filme_id) REFERENCES filmes(id)
);
```

```sql
CREATE TABLE livros_favoritos (
  id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  usuario_id INT NOT NULL,
  livro_id INT NOT NULL,
  FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
  FOREIGN KEY (livro_id) REFERENCES livros(id)
);
```

```sql
CREATE TABLE filmes_plataformas (
  id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  filme_id INT NOT NULL,
  plataforma_id INT NOT NULL,
  FOREIGN KEY (filme_id) REFERENCES filmes(id),
  FOREIGN KEY (plataforma_id) REFERENCES plataformas(id)
);
```

```sql
CREATE TABLE livros_plataformas (
  id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  livro_id INT NOT NULL,
  plataforma_id INT NOT NULL,
  FOREIGN KEY (livro_id) REFERENCES livros(id),
  FOREIGN KEY (plataforma_id) REFERENCES plataformas(id)
);
```
