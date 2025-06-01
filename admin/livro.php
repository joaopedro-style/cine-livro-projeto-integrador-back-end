<?php

use CineLivro\Auth\ControleDeAcesso;
use CineLivro\Enums\TipoUsuario;
use CineLivro\Helpers\Utils;
use CineLivro\Services\LivroServico;

require_once "../vendor/autoload.php";

ControleDeAcesso::exigirAdmin();

$livroServico = new LivroServico();
$listaDeLivros = $livroServico->listarTodos(TipoUsuario::ADMIN);

require_once "../includes/cabecalho-admin.php";

?>
<div class="row">
    <article class="col-12 bg-white rounded shadow my-1 py-4">

        <h2 class="text-center">
            Livros <span class="badge bg-dark"> <?= count($listaDeLivros) ?> </span>
        </h2>

        <p class="text-center mt-5">
            <a class="btn btn-primary" href="livro-cadastra.php">
                <i class="bi bi-plus-circle"></i>
                Inserir novo livro
            </a>
        </p>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Título</th>
                        <th>Autor</th>
                        <th>Data de Lançamento</th>
                        <th>Faixa etaria</th>
                        <th>Descrição</th>
                        <th>imagem capa URL</th>
                        <th>Gênero</th>
                        <th>Usuário</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($listaDeLivros as $dadosLivro) { ?>
                        <tr>
                            <td> <?= $dadosLivro['titulo'] ?></td>
                            <td> <?= $dadosLivro['autor'] ?></td>
                            <td> <?= Utils::formataData($dadosLivro['data_lancamento']) ?></td>
                            <td> <?= $dadosLivro['faixa_etaria'] ?></td>
                            <td> <?= $dadosLivro['descricao'] ?></td>
                            <td>
                                <a href="<?= $dadosLivro['imagem_capa_url'] ?>" target="_blank"><?= $dadosLivro['imagem_capa_url'] ?></a>
                            </td>
                            <td> <?= $dadosLivro['genero'] ?></td>
                            <td><?= $dadosLivro['nome_usuario'] ?></td>
                            <td class="text-center">
                                <a class="btn btn-warning" href="livro-atualiza.php?id=<?= $dadosLivro['id'] ?>">
                                    <i class="bi bi-pencil"></i> Atualizar
                                </a>
                                <a class="btn btn-danger excluir" href="livro-exclui.php?id=<?= $dadosLivro['id'] ?>">
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