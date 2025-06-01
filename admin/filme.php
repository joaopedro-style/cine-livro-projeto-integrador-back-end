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
<div class="container my-5">
    <article class="col-12 bg-black rounded shadow py-4">

        <h2 class="text-center text-white">
            Filmes <span class="badge bg-gradient"> <?= count($listaDeFilmes) ?> </span>
        </h2>

        <p class="text-center mt-5">
            <a class="btn btn-primary" href="filme-cadastra.php">
                <i class="bi bi-plus-circle"></i>
                Cadastrar novo filme
            </a>
        </p>

        <div class="table-responsive w-80 w-lg-100 mx-auto p-4 bg-light text-center border rounded container mt-5">
            <table class="table table-hover align-middle">
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
                                <td class="text-break"> <?= $dadosFilme['descricao'] ?></td>
                                <td class="text-break">
                                    <a href="<?= $dadosFilme['poster_url'] ?>" target="_blank"><?= $dadosFilme['poster_url'] ?></a>
                                </td>
                                <td class="text-center">
                                    <a class="btn btn-warning" href="filme-atualiza.php?id=<?= $dadosFilme['id'] ?>">
                                        <i class="bi bi-pencil"></i> Atualizar
                                    </a>
                                    <a class="btn btn-danger excluir" href="filme-exclui.php?id=<?= $dadosFilme['id'] ?>" onclick="return confirm('Tem certeza que deseja excluir este Filme?');">
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