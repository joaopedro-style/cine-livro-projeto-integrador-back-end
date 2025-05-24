<?php
require_once "../vendor/autoload.php";

use CineLivro\Auth\ControleDeAcesso;
use CineLivro\Enums\TipoUsuario;
use CineLivro\Services\FilmeServico;

ControleDeAcesso::exigirLogin();
$tipoUsuario = TipoUsuario::from($_SESSION['tipo']);
$idUsuario = $_SESSION['id'];

$filmeServico = new FilmeServico();
$listaDeFilmes = $filmeServico->listarTodos();

?>