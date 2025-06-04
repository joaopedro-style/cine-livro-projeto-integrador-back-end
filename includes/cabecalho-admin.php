<?php

use CineLivro\Auth\ControleDeAcesso;

ControleDeAcesso::exigirLogin();

if (isset($_GET['sair']))
    ControleDeAcesso::logoutadmin();
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.12.1/font/bootstrap-icons.min.css">
    <link rel="icon" type="image/png" sizes="32x32" href="../images/favicon-admin.png">

</head>

<body id="admin" class="d-flex flex-column bg-dark">

    <header id="topo" class="sticky-top">

        <nav class="navbar navbar-expand-lg py-5 navbar-dark bg-black justify-content-between">
            <div class="container">
                <h1>
                    <a class="navbar-brand d-flex align-items-center gap-2" href="index.php">
                        <img src="../imagens/cinelivro_logo_transparente.png" alt="Logo CineLivro" style="height: 95px; border-radius: 50%;">
                    </a>
                </h1>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link text-white me-3" href="index.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white me-3" href="meu-perfil.php">Meu perfil</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link text-white me-3" href="usuarios.php">Usuários</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white me-3" href="filme.php">Filmes</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white me-3" href="livro.php">Livros</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white me-3" href="genero.php">Generos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white me-3" href="plataforma.php">Plataformas</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-warning fw-bold" href="?sair">
                                <i class="bi bi-box-arrow-right"></i> Logout
                            </a>
                        </li>

                    </ul>

                </div>
            </div>
        </nav>

    </header>

    <main class="flex-grow-1">

    </main>