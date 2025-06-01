<?php

use CineLivro\Auth\ControleDeAcesso;
use CineLivro\Services\PlataformaServico;

require_once "../vendor/autoload.php";

ControleDeAcesso::exigirAdmin();

$plataformaServico = new PlataformaServico();
$listaDePlataformas = $plataformaServico->listarTodos();

require_once "../includes/cabecalho-admin.php";

?>
<div class="row">
    <article class="col-12 bg-white rounded shadow my-1 py-4">

        <h2 class="text-center">
            Plataformas <span class="badge bg-dark"> <?= count($listaDePlataformas) ?> </span>
        </h2>

        <p class="text-center mt-5">
            <a class="btn btn-primary" href="plataforma-cadastra.php">
                <i class="bi bi-plus-circle"></i>
                Cadastrar nova Plataforma
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
                    <?php foreach ($listaDePlataformas as $dadosPlataforma) { ?>
                        <tr>
                            <td> <?= $dadosPlataforma['nome'] ?></td>
                            <td class="text-center">
                                <a class="btn btn-warning" href="plataforma-atualiza.php?id=<?= $dadosGenero['id'] ?>">
                                    <i class="bi bi-pencil"></i> Atualizar
                                </a>
                                <a class="btn btn-danger excluir" href="plataforma-exclui.php?id=<?= $dadosPlataforma['id'] ?>" onclick="return confirm('Tem certeza que deseja excluir esta Plataforma?');">
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