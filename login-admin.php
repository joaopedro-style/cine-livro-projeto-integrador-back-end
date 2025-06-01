<?php

use CineLivro\Auth\ControleDeAcesso;
use CineLivro\Enums\TipoUsuario;
use CineLivro\Helpers\Utils;
use CineLivro\Services\UsuarioServico;

require_once "vendor/autoload.php";

$feedback = null;

if (isset($_GET["campos_obrigatorios"])) {
    $feedback = "Preencha e-mail e senha!";
} elseif (isset($_GET["dados_incorretos"])) {
    $feedback = "Email ou senha incorretos!";
} elseif (isset($_GET["logout"])) {
    $feedback = "Você saiu do sistema!";
} elseif (isset($_GET["acesso_negado"])) {
    $feedback = "Você não tem permissão para acessar essa área.";
} elseif (isset($_GET["erro"])) {
    $feedback = "Ocorreu um erro no sistema. Tente novamente mais tarde.";
}

if (isset($_POST['entrar'])) {
    $email = Utils::sanitizar($_POST['email'], 'email');
    $senha = $_POST['senha'];

    if (empty($email) || empty($senha)) {
        header("Location: login-admin.php?campos_obrigatorios");
        exit;
    }

    try {
        $usuarioServico = new UsuarioServico();
        $usuario = $usuarioServico->buscaPorEmail($email);

        if (!is_array($usuario) || !isset($usuario['senha'])) {
            header("Location: login-admin.php?dados_incorretos");
            exit;
        }

        if (password_verify($senha, $usuario['senha'])) {
            if (($usuario['tipo'] ?? 'usuario') !== TipoUsuario::ADMIN->value) {
                header("Location: login-admin.php?acesso_negado");
                exit;
            }

            ControleDeAcesso::login(
                $usuario['id'],
                $usuario['nome'],
                $usuario['tipo']
            );
            header("Location:admin/index.php");
            exit;
        } else {
            header("Location: login-admin.php?dados_incorretos");
            exit;
        }
    } catch (Throwable $erro) {
        Utils::registrarLog($erro);
        header("Location: login-admin.php?erro");
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
                        <?php if (isset($_SESSION['id'])) : ?>
                            <li class="nav-item"><a href="usuario.php" class="nav-link text-light">Perfil</a></li>
                        <?php endif; ?>
                    </ul>
                </nav>
            </div>
        </div>
    </header>
    <div class="container my-5">
        <div class="col-12 bg-black rounded shadow py-4">
            <h2 class="text-center fw-light text-white">Acesso à área administrativa</h2>

            <form action="" method="post" id="form-login" name="form-login" class="mx-auto w-50" autocomplete="off">
                <?php if (isset($feedback)) : ?>
                    <p class="my-2 alert alert-warning text-center">
                        <?= $feedback ?>
                    </p>
                <?php endif; ?>

                <div class="mb-3 text-white">
                    <label for="email" class="form-label">E-mail:</label>
                    <input autofocus class="form-control" type="email" id="email" name="email">
                </div>
                <div class="mb-3 text-white">
                    <label for="senha" class="form-label">Senha:</label>
                    <input class="form-control" type="password" id="senha" name="senha">
                </div>

                <button class="btn btn-primary btn-lg" name="entrar" type="submit">Entrar</button>
            </form>
        </div>
    </div>

    <footer class="footer-cinelivro text-center py-3 mt-5">
        <div class="container d-flex justify-content-center align-items-center gap-4">
            <a href="index.php">
                <img src="imagens/cinelivro_logo_transparente.png" alt="Logo CineLivro" class="logo-img">
            </a>
            <nav>
                <ul class="nav navbar-cinelivro">
                    <li class="nav-item"><a href="index.php" class="nav-link text-light">Home</a></li>
                    <li class="nav-item"><a href="filmes.php" class="nav-link text-light">Filmes</a></li>
                    <li class="nav-item"><a href="livros.php" class="nav-link text-light">Livros</a></li>
                    <?php if (isset($_SESSION['id'])) : ?>
                        <li class="nav-item"><a href="usuario.php" class="nav-link text-light">Perfil</a></li>
                    <?php endif; ?>
                    <li class="nav-item"><a href="login-admin.php" class="nav-link text-light"></i>Admin</a></li>
                </ul>
            </nav>
            <p class="mb-0">&copy; 2025 CineLivro. Todos os direitos reservados.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="script.js"></script>
</body>

</html>