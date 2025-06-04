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
<div class="container my-5">
    <article class="col-12 bg-dark rounded shadow py-4">

        <h2 class="text-center text-white">
            Livros <span class="badge bg-gradient"> <?= count($listaDeLivros) ?> </span>
        </h2>

        <p class="text-center mt-5">
            <a class="btn btn-primary" href="livro-cadastra.php">
                <i class="bi bi-plus-circle"></i>
                Cadastrar novo livro
            </a>
        </p>

        <div class="table-responsive w-80 w-lg-100 mx-auto p-4 bg-light text-center border rounded container mt-5">
            <table class="table table-hover align-middle">
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
                                <td class="text-break"> <?= $dadosLivro['descricao'] ?></td>
                                <td class="text-break">
                                    <a href="<?= $dadosLivro['imagem_capa_url'] ?>" target="_blank"><?= $dadosLivro['imagem_capa_url'] ?></a>
                                </td>
                                <td> <?= $dadosLivro['genero'] ?></td>
                                <td class="text-center">
                                    <a class="btn btn-warning" href="livro-atualiza.php?id=<?= $dadosLivro['id'] ?>">
                                        <i class="bi bi-pencil"></i> Atualizar
                                    </a>
                                    <a class="btn btn-danger excluir" href="livro-exclui.php?id=<?= $dadosLivro['id'] ?>" onclick="return confirm('Tem certeza que deseja excluir este Livro?');">
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