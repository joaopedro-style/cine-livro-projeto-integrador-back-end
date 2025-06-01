<?php
require_once "vendor/autoload.php";
use CineLivro\Auth\ControleDeAcesso;
use CineLivro\Services\UsuarioServico;
use CineLivro\Helpers\Utils;
use CineLivro\Helpers\Validacoes;
use CineLivro\Models\Usuario;
use CineLivro\Enums\TipoUsuario;
use CineLivro\Services\FilmeServico;
use CineLivro\Services\LivroServico;

ControleDeAcesso::iniciarsessao();
ControleDeAcesso::exigirLogin();

$usuarioServico = new UsuarioServico();
$usuario = $usuarioServico->buscarPorId($_SESSION['id']);
$mensagemDeErro = "";
$mensagemDeSucesso = "";

if (!$usuario) {
    header('Location: login.php?erro');
    exit;
}

// Buscar filmes e livros favoritos
try {
    $filmeServico = new FilmeServico();
    $livroServico = new LivroServico();
    
    $sql = "SELECT f.*, ff.id as favorito_id 
            FROM filmes f 
            INNER JOIN filmes_favoritos ff ON f.id = ff.filme_id 
            WHERE ff.usuario_id = :usuario_id";
    $consulta = $filmeServico->getConexao()->prepare($sql);
    $consulta->bindValue(':usuario_id', $_SESSION['id'], PDO::PARAM_INT);
    $consulta->execute();
    $filmesFavoritos = $consulta->fetchAll(PDO::FETCH_ASSOC);

    $sql = "SELECT l.*, lf.id as favorito_id 
            FROM livros l 
            INNER JOIN livros_favoritos lf ON l.id = lf.livro_id 
            WHERE lf.usuario_id = :usuario_id";
    $consulta = $livroServico->getConexao()->prepare($sql);
    $consulta->bindValue(':usuario_id', $_SESSION['id'], PDO::PARAM_INT);
    $consulta->execute();
    $livrosFavoritos = $consulta->fetchAll(PDO::FETCH_ASSOC);
} catch (Throwable $erro) {
    Utils::registrarLog($erro);
    $filmesFavoritos = [];
    $livrosFavoritos = [];
    $mensagemDeErro = "Erro ao carregar favoritos.";
}

if (isset($_POST["atualizar"])) {
    try {
        $nome = Utils::sanitizar($_POST["nome"]);
        Validacoes::validarNome($nome);

        $email = Utils::sanitizar($_POST["email"], 'email');
        Validacoes::validarEmail($email);

        $senhaBruta = $_POST["senha"];
        $senha = empty($senhaBruta) ? $usuario["senha"] : Utils::codificarSenha($senhaBruta);

        $data_nascimento = $_POST["data_nascimento"];
        Validacoes::validarDataNascimento($data_nascimento);

        $tipo = TipoUsuario::from($usuario["tipo"]);
        $id = $_SESSION['id'];

        $usuarioAtualizado = new Usuario($nome, $email, $senha, $data_nascimento, $tipo, $id);
        $usuarioServico->atualizar($usuarioAtualizado);

        $_SESSION["nome"] = $nome;
        $usuario = $usuarioServico->buscarPorId($_SESSION['id']);
        $mensagemDeSucesso = "Perfil atualizado com sucesso!";
    } catch (Throwable $erro) {
        $mensagemDeErro = "Erro ao atualizar perfil.";
        Utils::registrarLog($erro);
    }
}
?>
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
                        <li class="nav-item"><a href="usuario.php" class="nav-link text-light">Perfil</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>

    <main class="user-profile">
        <div class="profile-header">
            <div class="profile-info">
                <h1 class="profile-name"><?= htmlspecialchars($usuario['nome']) ?></h1>
                <div class="profile-actions">
                    <button class="edit-button" onclick="toggleEditForm()"><i class="fas fa-edit"></i> Editar Perfil</button>
                </div>
            </div>
        </div>

        <?php if (!empty($mensagemDeErro)) : ?>
            <div class="alert alert-danger text-center" role="alert">
                <?= $mensagemDeErro ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($mensagemDeSucesso)) : ?>
            <div class="alert alert-success text-center" role="alert">
                <?= $mensagemDeSucesso ?>
            </div>
        <?php endif; ?>

        <div id="editForm" class="section-card" style="display: none;">
            <h2 class="section-title"><i class="fas fa-user-edit"></i> Editar Perfil</h2>
            <form action="" method="POST" class="edit-profile-form">
                <div class="mb-3">
                    <label for="nome" class="form-label">Nome</label>
                    <input type="text" class="form-control" id="nome" name="nome" value="<?= htmlspecialchars($usuario['nome']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($usuario['email']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="senha" class="form-label">Nova Senha (deixe em branco para manter a atual)</label>
                    <input type="password" class="form-control" id="senha" name="senha">
                </div>
                <div class="mb-3">
                    <label for="data_nascimento" class="form-label">Data de Nascimento</label>
                    <input type="date" class="form-control" id="data_nascimento" name="data_nascimento" value="<?= htmlspecialchars($usuario['data_nascimento']) ?>" required>
                </div>
                <div class="d-grid gap-2">
                    <button type="submit" name="atualizar" class="btn btn-primary">Salvar Alterações</button>
                    <button type="button" class="btn btn-secondary" onclick="toggleEditForm()">Cancelar</button>
                </div>
            </form>
        </div>

        <div class="profile-sections">
            <div class="section-card">
                <h2 class="section-title"><i class="fas fa-user"></i> Informações Pessoais</h2>
                <div class="info-grid">
                    <div class="info-item">
                        <i class="fas fa-user-circle"></i>
                        <div>
                            <strong>Nome:</strong>
                            <?= htmlspecialchars($usuario['nome']) ?>
                        </div>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-envelope"></i>
                        <div>
                            <strong>Email:</strong>
                            <?= htmlspecialchars($usuario['email']) ?>
                        </div>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-calendar-alt"></i>
                        <div>
                            <strong>Data de Nascimento:</strong>
                            <?= htmlspecialchars(Utils::formataData($usuario['data_nascimento'])) ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="section-card">
                <h2 class="section-title"><i class="fas fa-heart"></i> Filmes favoritos</h2>
                <div class="favorites-content">
                    <div class="favorites-list active" id="filmes">
                        <?php foreach ($filmesFavoritos as $filme): ?>
                        <div class="favorite-item">
                            <img src="<?= htmlspecialchars($filme['poster_url']) ?>" alt="<?= htmlspecialchars($filme['titulo']) ?>" class="favorite-image">
                            <div class="favorite-info">
                                <h5><?= htmlspecialchars($filme['titulo']) ?></h5>
                            </div>
                            <button class="remove-favorite" title="Remover dos favoritos" data-id="<?= $filme['id'] ?>" data-tipo="filme">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <div class="section-card">
                <h2 class="section-title"><i class="fas fa-heart"></i> Livros favoritos</h2>
                <div class="favorites-content">
                    <div class="favorites-list active" id="livros">
                        <?php foreach ($livrosFavoritos as $livro): ?>
                        <div class="favorite-item">
                            <img src="<?= htmlspecialchars($livro['imagem_capa_url']) ?>" alt="<?= htmlspecialchars($livro['titulo']) ?>" class="favorite-image">
                            <div class="favorite-info">
                                <h5><?= htmlspecialchars($livro['titulo']) ?></h5>
                            </div>
                            <button class="remove-favorite" title="Remover dos favoritos" data-id="<?= $livro['id'] ?>" data-tipo="livro">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer class="footer-cinelivro text-center py-3 mt-5">
        <div class="container d-flex justify-content-center align-items-center gap-4">
            <img src="imagens/cinelivro_logo_transparente.png" alt="Logo CineLivro" class="logo-img">
            <nav>
                <ul class="nav navbar-cinelivro">
                    <li class="nav-item"><a href="index.php" class="nav-link text-light">Home</a></li>
                    <li class="nav-item"><a href="filmes.php" class="nav-link text-light">Filmes</a></li>
                    <li class="nav-item"><a href="livros.php" class="nav-link text-light">Livros</a></li>
                    <li class="nav-item"><a href="usuario.php" class="nav-link text-light">Perfil</a></li>
                </ul>
            </nav>
            <p class="mb-0">&copy; 2025 CineLivro. Todos os direitos reservados.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="script.js"></script>
    <script src="js/favoritos.js"></script>
    <script src="js/busca.js"></script>
    <script>
        function toggleEditForm() {
            const form = document.getElementById('editForm');
            form.style.display = form.style.display === 'none' ? 'block' : 'none';
        }
    </script>
</body>

</html>
