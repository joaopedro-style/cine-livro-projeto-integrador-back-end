<?php

use CineLivro\Auth\ControleDeAcesso;

require_once "../vendor/autoload.php";

ControleDeAcesso::exigirAdmin();

require_once "../includes/cabecalho-admin.php";
?>
<div class="container my-5">
    <article class="p-5 my-4 rounded-3 bg-black shadow">

        <h2 class="text-white display-4">Bem-Vindo <?= $_SESSION['nome'] ?>!</h2>

        <?php if (isset($_GET["perfil_atualizado"])) { ?>
            <p class="alert alert-primary">Dados atualizados com sucesso!</p>
        <?php } ?>

        <p class="text-white fs-5">você está na Área administrativa
            <hr class="my-4">

        <div class="d-grid gap-2 d-md-block text-center">
            <a class="btn btn-light btn-lg ms-2" href="meu-perfil.php">
                <i class="bi bi-person"></i> <br>
                Meu perfil
            </a>

            <a class="btn btn-light btn-lg ms-2" href="usuarios.php">
                <i class="bi bi-person"></i> <br>
                Usuários
            </a>
            <a class="btn btn-light btn-lg ms-2" href="filme.php">
                <i class="bi bi-film"></i> <br>
                Filmes
            </a>
            <a class="btn btn-light btn-lg ms-2" href="livro.php">
                <i class="bi bi-book"></i> <br>
                Livros
            </a>
            <a class="btn btn-light btn-lg ms-2" href="genero.php">
                <i class="bi bi-tag"></i> <br>
                Generos
            </a>
            <a class="btn btn-light btn-lg ms-2" href="plataforma.php">
                <i class="bi bi-globe"></i> <br>
                Plataformas
            </a>
        </div>
    </article>
</div>



<?php
require_once "../includes/rodape-admin.php";
?>