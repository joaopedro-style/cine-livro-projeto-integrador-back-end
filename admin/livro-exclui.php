<?php

use CineLivro\Auth\ControleDeAcesso;
use CineLivro\Enums\TipoUsuario;
use CineLivro\Helpers\Utils;
use CineLivro\Services\LivroServico;

require_once "../vendor/autoload.php";

ControleDeAcesso::exigirLogin();
ControleDeAcesso::exigirAdmin();

$livroServico = new LivroServico();

$id = Utils::sanitizar($_GET['id'], 'inteiro');
Utils::verificarId($id);

$livroServico->excluir($id, TipoUsuario::ADMIN);

header(("location:livro.php"));
exit;