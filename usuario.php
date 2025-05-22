<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil do Usuário - CineLivro</title>
    <link rel="icon" type="image/png" href="imagens/cinelivro_logo_transparente.png">
    <link rel="apple-touch-icon" href="imagens/cinelivro_logo_transparente.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <!-- Header -->
    <header class="bg-cinelivro border-bottom border-dark py-3 mb-4">
        <div class="container d-flex flex-wrap justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <a href="index.php">
                    <img src="imagens/cinelivro_logo_transparente.png" alt="Logo CineLivro" class="logo-img">
                </a>
            </div>
            <div class="d-flex align-items-center">
                <div class="search-container">
                    <input type="text" class="search-input" placeholder="Buscar filmes, livros...">
                    <button class="search-button">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
                <nav>
                    <ul class="nav navbar-cinelivro">
                        <li class="nav-item"><a href="index.php" class="nav-link text-light">Home</a></li>
                        <li class="nav-item"><a href="filmes.php" class="nav-link text-light">Filmes</a></li>
                        <li class="nav-item"><a href="livros.php" class="nav-link text-light">Livros</a></li>
                        <li class="nav-item"><a href="usuario.php" class="nav-link text-light">Usuário</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>

    <!-- Conteúdo Principal -->
    <main class="user-profile">
        <div class="profile-header">
            <div class="profile-avatar-container">
                <img src="imagens/avatar-padrao.jpg" alt="Avatar do Usuário" class="profile-avatar">
            </div>
            <div class="profile-info">
                <h1 class="profile-name">Nome do Usuário</h1>
                <p class="profile-email"><i class="fas fa-envelope"></i> usuario@email.com</p>
                <div class="profile-actions">
                    <button class="edit-button"><i class="fas fa-edit"></i> Editar Perfil</button>
                </div>
            </div>
        </div>

        <div class="profile-sections">
            <div class="section-card">
                <h2 class="section-title"><i class="fas fa-user"></i> Informações Pessoais</h2>
                <div class="info-grid">
                    <div class="info-item">
                        <i class="fas fa-user-circle"></i>
                        <div>
                            <strong>Nome:</strong>
                            <p>Nome Completo</p>
                        </div>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-envelope"></i>
                        <div>
                            <strong>Email:</strong>
                            <p>usuario@email.com</p>
                        </div>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-calendar-alt"></i>
                        <div>
                            <strong>Data de Cadastro:</strong>
                            <p>01/01/2024</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="section-card">
                <h2 class="section-title"><i class="fas fa-heart"></i> Favoritos</h2>
                <div class="favorites-tabs">
                    <button class="tab-button active" data-tab="filmes">Filmes</button>
                    <button class="tab-button" data-tab="livros">Livros</button>
                </div>
                
                <div class="favorites-content">
                    <div class="favorites-list active" id="filmes">
                        <div class="favorite-item">
                            <img src="https://www.themoviedb.org/t/p/w600_and_h900_bestv2/8uVKfOJUhmybNsVh089EqLHUYEG.jpg" alt="Duna" class="favorite-image">
                            <div class="favorite-info">
                                <h5>Duna: Parte Dois</h5>
                                <div class="stars">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                </div>
                            </div>
                            <button class="remove-favorite" title="Remover dos favoritos">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        <!-- Mais filmes favoritos aqui -->
                    </div>
                    
                    <div class="favorites-list" id="livros">
                        <div class="favorite-item">
                            <img src="https://m.media-amazon.com/images/I/81YzHKeWq7L._AC_UF1000,1000_QL80_.jpg" alt="Duna" class="favorite-image">
                            <div class="favorite-info">
                                <h5>Duna</h5>
                                <p class="author">Frank Herbert</p>
                            </div>
                            <button class="remove-favorite" title="Remover dos favoritos">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        <!-- Mais livros favoritos aqui -->
                    </div>
                </div>
            </div>

            <div class="section-card">
                <h2 class="section-title"><i class="fas fa-star"></i> Últimas Avaliações</h2>
                <div class="reviews-list">
                    <div class="review-item">
                        <div class="review-header">
                            <img src="https://www.themoviedb.org/t/p/w600_and_h900_bestv2/8uVKfOJUhmybNsVh089EqLHUYEG.jpg" alt="Duna" class="review-image">
                            <div class="review-info">
                                <h5>Duna: Parte Dois</h5>
                                <div class="stars">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="footer-cinelivro text-center py-3 mt-5">
        <div class="container d-flex justify-content-center align-items-center gap-4">
            <img src="imagens/cinelivro_logo_transparente.png" alt="Logo CineLivro" class="logo-img">
            <nav>
                <ul class="nav navbar-cinelivro">
                    <li class="nav-item"><a href="index.php" class="nav-link text-light">Home</a></li>
                    <li class="nav-item"><a href="filmes.php" class="nav-link text-light">Filmes</a></li>
                    <li class="nav-item"><a href="livros.php" class="nav-link text-light">Livros</a></li>
                    <li class="nav-item"><a href="usuario.php" class="nav-link text-light">Usuário</a></li>
                </ul>
            </nav>
            <p class="mb-0">&copy; 2024 CineLivro. Todos os direitos reservados.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="script.js"></script>
</body>
</html> 