<?php

use CineLivro\Auth\ControleDeAcesso;
use CineLivro\Services\PlataformaServico;

require_once "../vendor/autoload.php";

ControleDeAcesso::exigirAdmin();

$plataformaServico = new PlataformaServico();
$listaDePlataformas = $plataformaServico->listarTodos();

require_once "../includes/cabecalho-admin.php";

?>
<div class="container my-5">
    <article class="col-12 bg-black rounded shadow py-4">

        <h2 class="text-center text-white">
            Plataformas <span class="badge bg-gradient"> <?= count($listaDePlataformas) ?> </span>
        </h2>

        <p class="text-center mt-5 text-white">
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
                                <a class="btn btn-warning" href="plataforma-atualiza.php?id=<?= $dadosPlataforma['id'] ?>">
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
    </article>
</div>


<?php
require_once "../includes/rodape-admin.php";
?>