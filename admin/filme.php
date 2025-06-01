<?php

use CineLivro\Auth\ControleDeAcesso;
use CineLivro\Enums\TipoUsuario;
use CineLivro\Helpers\Utils;
use CineLivro\Services\FilmeServico;

require_once "../vendor/autoload.php";

ControleDeAcesso::exigirAdmin();

$filmeServico = new FilmeServico();
$listaDeFilmes = $filmeServico->listarTodos(TipoUsuario::ADMIN);

require_once "../includes/cabecalho-admin.php";

?>

<div class="row">
    <article class="col-12 bg-white rounded shadow my-1 py-4">

        <h2 class="text-center">
            Filmes <span class="badge bg-dark"> <?= count($listaDeFilmes) ?> </span>
        </h2>

        <p class="text-center mt-5">
            <a class="btn btn-primary" href="filme-cadastra.php">
                <i class="bi bi-plus-circle"></i>
                Inserir novo filme
            </a>
        </p>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Título</th>
                        <th>Diretor</th>
                        <th>Data de Lançamento</th>
                        <th>Duração </th>
                        <th>Classificação</th>
                        <th>Gênero</th>
                        <th>Descrição</th>
                        <th>Poster URL</th>
                        <th>Usuário</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($listaDeFilmes as $dadosFilme) { ?>
                        <tr>
                            <td> <?= $dadosFilme['titulo'] ?></td>
                            <td> <?= $dadosFilme['diretor'] ?></td>
                            <td> <?= Utils::formataData($dadosFilme['data_lancamento']) ?></td>
                            <td> <?= $dadosFilme['duracao'] ?></td>
                            <td> <?= $dadosFilme['classificacao'] ?></td>
                            <td> <?= $dadosFilme['genero'] ?></td>
                            <td> <?= $dadosFilme['descricao'] ?></td>
                            <td>
                                <a href="<?= $dadosFilme['poster_url'] ?>" target="_blank"><?= $dadosFilme['poster_url'] ?></a>
                            </td>
                            <td><?= $dadosFilme['nome_usuario'] ?></td>
                            <td class="text-center">
                                <a class="btn btn-warning" href="filme-atualiza.php?id=<?= $dadosFilme['id'] ?>">
                                    <i class="bi bi-pencil"></i> Atualizar
                                </a>
                                <a class="btn btn-danger excluir" href="filme-exclui.php?id=<?= $dadosFilme['id'] ?>">
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