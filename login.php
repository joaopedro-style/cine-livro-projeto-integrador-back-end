<?php

use CineLivro\Auth\ControleDeAcesso;
use CineLivro\Helpers\Utils;
use CineLivro\Services\UsuarioServico;

require_once 'vendor/autoload.php';

$feedback = null;

if (isset($_GET["campos_obrigatorios"])) {
    $feedback = "Preencha e-mail e senha!";
} elseif (isset($_GET["dados_incorretos"])) {
    $feedback = "Email ou senha incorretos!";
} elseif (isset($_GET["logout"])) {
    $feedback = "Você saiu do sistema!";
} elseif (isset($_GET["acesso_negado"])) {
    $feedback = "Você deve logar primeiro.";
} elseif (isset($_GET["erro"])) {
    $feedback = "Ocorreu um erro no sistema. Tente novamente mais tarde.";
}

if (isset($_POST['entrar'])) {
    $email = Utils::sanitizar($_POST['email'], 'email');
    $senha = $_POST['senha'];

    if (empty($email) || empty($senha)) {
        header("Location: login.php?campos_obrigatorios");
        exit;
    }

    try {
        $usuarioServico = new UsuarioServico();
        $usuario = $usuarioServico->buscaPorEmail($email);

        if (!is_array($usuario) || !isset($usuario['senha'])) {
            header("Location: login.php?dados_incorretos");
            exit;
        }

        if (password_verify($senha, $usuario['senha'])) {
            ControleDeAcesso::login(
                $usuario['id'],
                $usuario['nome'],
                $usuario['tipo'] ?? 'usuario'
            );
            header("Location: index.php");
            exit;
        } else {
            header("Location: login.php?dados_incorretos");
            exit;
        }
    } catch (Throwable $e) {
        Utils::registrarLog($e);
        header("Location: login.php?erro");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - CineLivro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
    <link rel="icon" type="image/png" href="imagens/cinelivro_logo_transparente.png">
    <link rel="apple-touch-icon" href="imagens/cinelivro_logo_transparente.png">
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

    <main class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="login-card">
                    <h2 class="text-center mb-4">Login</h2>
                    <form action="" method="POST">
                        <?php if (isset($feedback)) : ?>
                            <div class="alert alert-warning text-center">
                                <?= $feedback ?>
                            </div>
                        <?php endif; ?>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="senha" class="form-label">Senha</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                <input type="password" class="form-control" id="senha" name="senha" required>
                            </div>
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="lembrar" name="lembrar">
                            <label class="form-check-label" for="lembrar">Lembrar-me</label>
                        </div>
                        <button type="submit" name="entrar" class="btn btn-primary w-100 mb-3">Entrar</button>
                        <div class="text-center">
                            <p class="mb-2">Não tem uma conta? <a href="cadastro.php" class="text-primary">Cadastre-se</a></p>
                        </div>
                    </form>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="script.js"></script>
</body>

</html>