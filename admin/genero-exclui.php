<?php

use CineLivro\Auth\ControleDeAcesso;
use CineLivro\Helpers\Utils;
use CineLivro\Services\GeneroServico;

require_once "../vendor/autoload.php";

ControleDeAcesso::exigirLogin();
ControleDeAcesso::exigirAdmin();

$generoServico = new GeneroServico();

$id = Utils::sanitizar($_GET['id'], 'inteiro');
Utils::verificarId($id);

$generoServico->excluir($id);

header("location:genero.php");
exit;