<?php

use CineLivro\Auth\ControleDeAcesso;
use CineLivro\Services\GeneroServico;

require_once "../vendor/autoload.php";

ControleDeAcesso::exigirAdmin();

$generoServico = new GeneroServico();
$listaDeGeneros = $generoServico->listarTodos();

require_once "../includes/cabecalho-admin.php";

?>
<div class="row">
    <article class="col-12 bg-white rounded shadow my-1 py-4">

        <h2 class="text-center">
            Generos <span class="badge bg-dark"> <?= count($listaDeGeneros) ?> </span>
        </h2>

        <p class="text-center mt-5">
            <a class="btn btn-primary" href="genero-cadastra.php">
                <i class="bi bi-plus-circle"></i>
                Cadastrar novo Genero
            </a>
        </p>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Nome</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($listaDeGeneros as $dadosGenero) { ?>
                        <tr>
                            <td> <?= $dadosGenero['nome'] ?></td>
                            <td class="text-center">
                                <a class="btn btn-warning" href="genero-atualiza.php?id=<?= $dadosGenero['id'] ?>">
                                    <i class="bi bi-pencil"></i> Atualizar
                                </a>
                                <a class="btn btn-danger excluir" href="genero-exclui.php?id=<?= $dadosGenero['id'] ?>" onclick="return confirm('Tem certeza que deseja excluir este Genero?');">
                                    <i class="bi bi-trash"></i> Excluir
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </article>

    <?php
    require_once "../includes/rodape-admin.php";
    ?>