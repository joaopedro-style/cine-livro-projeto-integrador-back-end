<?php
session_start();

use CineLivro\Models\Usuario;
use CineLivro\Services\UsuarioServico;
use CineLivro\Enums\TipoUsuario;
use CineLivro\Helpers\Utils;
use CineLivro\Helpers\Validacoes;
use CineLivro\Auth\ControleDeAcesso;

require_once "vendor/autoload.php";

if (isset($_POST["cadastrar"])) {
    try {
        $nome = Utils::sanitizar($_POST['nome']);
        Validacoes::validarNome($nome);

        $email = Utils::sanitizar($_POST['email'], 'email');
        Validacoes::validarEmail($email);

        $data_nascimento = $_POST['data_nascimento'];
        Validacoes::validarDataNascimento($data_nascimento);
        $data_nascimento_formatada = (new DateTime($data_nascimento))->format('Y-m-d');

        $senhaBruta = $_POST['senha'];
        Validacoes::validarSenha($senhaBruta);
        $senha = Utils::codificarSenha($senhaBruta);

        $usuarioServico = new UsuarioServico();
        if ($usuarioServico->buscaPorEmail($email)) {
            throw new Exception("Este email já está cadastrado.");
        }

        $usuario = new Usuario($nome, $email, $senha, $data_nascimento_formatada, TipoUsuario::PADRÃO);
        $usuarioServico->cadastrar($usuario);

        $usuarioDados = $usuarioServico->buscaPorEmail($email);
        if ($usuarioDados && isset($usuarioDados['id'])) {
            ControleDeAcesso::login(
                $usuarioDados['id'],
                $usuarioDados['nome'],
                $usuarioDados['tipo'] ?? 'padrão'
            );

            $_SESSION['success'] = "Cadastro realizado com sucesso!";
            $_SESSION['success_redirect'] = true;
            header('Location: cadastro.php');
            exit;
        } else {
            throw new Exception("Não foi possível realizar o login.");
        }
    } catch (Throwable $erro) {
        Utils::registrarLog($erro);
        $_SESSION['error'] = $erro->getMessage();
        header('Location: cadastro.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - CineLivro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
    <link rel="icon" type="image/png" href="imagens/cinelivro_logo_transparente.png">
    <link rel="apple-touch-icon" href="imagens/cinelivro_logo_transparente.png">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a href="index.php">
                <img src="imagens/cinelivro_logo_transparente.png" alt="Logo CineLivro" class="logo-img">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="nav navbar-cinelivro">
                    <li class="nav-item"><a href="index.php" class="nav-link text-light">Home</a></li>
                    <li class="nav-item"><a href="filmes.php" class="nav-link text-light">Filmes</a></li>
                    <li class="nav-item"><a href="livros.php" class="nav-link text-light">Livros</a></li>
                    <?php if (isset($_SESSION['id'])) : ?>
                        <li class="nav-item"><a href="usuario.php" class="nav-link text-light">Perfil</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title text-center mb-3">Cadastro</h2>

                        <?php if (isset($_SESSION['error'])) : ?>
                            <div class="alert alert-danger text-center">
                                <?= $_SESSION['error'];
                                unset($_SESSION['error']); ?>
                            </div>
                        <?php endif; ?>

                        <?php if (isset($_SESSION['success'])) : ?>
                            <div class="alert alert-success text-center">
                                <?= $_SESSION['success'];
                                unset($_SESSION['success']); ?>
                            </div>
                        <?php endif; ?>

                        <?php if (isset($_SESSION['success_redirect'])) : ?>
                            <script>
                                setTimeout(function() {
                                    window.location.href = 'index.php';
                                }, 3000);
                            </script>
                            <?php unset($_SESSION['success_redirect']); ?>
                        <?php endif; ?>

                        <form action="cadastro.php" method="POST">
                            <div class="mb-3">
                                <label for="nome" class="form-label text-white">Nome</label>
                                <input type="text" class="form-control" id="nome" name="nome" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label text-white">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="senha" class="form-label text-white">Senha</label>
                                <input type="password" class="form-control" id="senha" name="senha" required>
                            </div>
                            <div class="mb-3">
                                <label for="data_nascimento" class="form-label text-white">Data de Nascimento</label>
                                <input type="date" class="form-control" id="data_nascimento" name="data_nascimento" required>
                            </div>
                            <div class="d-grid">
                                <button type="submit" name="cadastrar" class="btn btn-primary">Cadastrar</button>
                            </div>
                        </form>

                        <div class="text-center mt-3">
                            <a href="login.php">Já tem uma conta? Faça login</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
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
                    <li class="nav-item"><a href="login-admin.php" class="nav-link text-light">Admin</a></li>
                </ul>
            </nav>
            <p class="mb-0">&copy; 2025 CineLivro. Todos os direitos reservados.</p>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="script.js"></script>
</body>

</html>