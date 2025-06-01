<?php

use CineLivro\Auth\ControleDeAcesso;
use CineLivro\Helpers\Utils;
use CineLivro\Services\FilmeServico;
use CineLivro\Enums\TipoUsuario;

require_once "../vendor/autoload.php";

ControleDeAcesso::exigirLogin();
ControleDeAcesso::exigirAdmin();

$filmeServico = new FilmeServico();

$id = Utils::sanitizar($_GET['id'], 'inteiro');
Utils::verificarId($id);

$filmeServico->excluir($id, TipoUsuario::ADMIN);

header("location:filme.php");
exit;
