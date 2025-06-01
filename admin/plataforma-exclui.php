<?php

use CineLivro\Auth\ControleDeAcesso;
use CineLivro\Helpers\Utils;
use CineLivro\Services\PlataformaServico;

require_once "../vendor/autoload.php";

ControleDeAcesso::exigirLogin();
ControleDeAcesso::exigirAdmin();

$plataformaServico = new PlataformaServico();

$id = Utils::sanitizar($_GET['id'], 'inteiro');
Utils::verificarId($id);

$plataformaServico->excluir($id);

header("location:plataforma.php");
exit;