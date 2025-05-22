<?php

use CineLivro\Services\UsuarioServico;

require_once "../vendor/autoload.php";

$usuarioServico = new UsuarioServico();
$listaDeUsuario = $usuarioServico->listarTodos();
?>

