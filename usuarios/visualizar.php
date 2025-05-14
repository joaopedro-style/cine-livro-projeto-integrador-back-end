<?php

use CineLivro\Services\UsuarioServico;

require_once "../vendor/autoload.php";

$usuarioServico = new UsuarioServico();
$listaDeUsuarios = $usuarioServico->listarTodos();
$quantidade = count($listaDeUsuarios);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios - Visualização</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-2 shadow-lg rounded">
        <h1><a class="btn btn-dark btn-lg" href="../index.php">Home</a> Usuarios | SELECT </h1>

        <hr>
        <h2>Lendo e carregando todos os Usuarios.</h2>

        <p><a class="btn btn-primary btn-sm" href="cadastrar.php">Cadastrar novo usuario</a></p>


        <table class="table table-hover table-bordered w-100">
            <caption>Lista de Usuarios: <?= $quantidade ?> </caption>
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Data de nascimento</th>
                </tr>
            </thead>
            <tbody>

                <?php foreach ($listaDeUsuarios as $usuario) { ?>
                    <tr>
                        <td> <?= $usuario['id'] ?></td>
                        <td> <?= $usuario['nome'] ?></td>
                        <td> <?= $usuario['email'] ?></td>
                        <td> <?= $usuario['data_nascimento'] ?></td>
                        <td>
                            <a class="btn btn-warning btn-sm" href="atualizar.php?id=<?= $usuario['id'] ?>">Atualizar</a>

                            <a class="btn btn-danger btn-sm" href="excluir.php?id=<?= $usuario['id'] ?>">Excluir</a>
                        </td>
                    </tr>
                <?php } ?>

            </tbody>
        </table>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>