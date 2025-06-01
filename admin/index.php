<?php

use CineLivro\Auth\ControleDeAcesso;

require_once "../vendor/autoload.php";
require_once "../includes/cabecalho-admin.php";

ControleDeAcesso::exigirAdmin();
?>
<article class="p-5 my-4 rounded-3 bg-white shadow">
    <div class="container-fluid py-1">        

        <h2 class="display-4">Bem-Vindo <?=$_SESSION['nome']?>!</h2>

        <?php if( isset($_GET["perfil_atualizado"]) ){ ?>
            <p class="alert alert-primary">Dados atualizados com sucesso!</p>
        <?php } ?>

        <p class="fs-5">você está na Área administrativa
        <span class="badge bg-dark"> <?=$_SESSION['tipo']?> </span>.</p>
        <hr class="my-4">

        <div class="d-grid gap-2 d-md-block text-center">
            <a class="btn btn-dark bg-gradient btn-lg" href="meu-perfil.php">
                <i class="bi bi-person"></i> <br>
                Meu perfil
            </a>
			
			<a class="btn btn-dark bg-gradient btn-lg" href="usuarios.php">
                <i class="bi bi-newspaper"></i> <br>
                Usuários
            </a>
                <a class="btn btn-dark bg-gradient btn-lg" href="filme.php">
                <i class="bi bi-tags"></i> <br>
                Filmes
            </a>
			<a class="btn btn-dark bg-gradient btn-lg" href="livro.php">
                <i class="bi bi-people"></i> <br>
                Livros
            </a>
            <a class="btn btn-dark bg-gradient btn-lg" href="genero.php">
                <i class="bi bi-people"></i> <br>
                Generos
            </a>
            <a class="btn btn-dark bg-gradient btn-lg" href="plataforma.php">
                <i class="bi bi-people"></i> <br>
                Plataformas
            </a>
        </div>
    </div>
</article>


<?php 
require_once "../includes/rodape-admin.php";
?>

