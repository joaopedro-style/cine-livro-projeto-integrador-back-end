<?php

use CineLivro\Auth\ControleDeAcesso;
use CineLivro\Enums\TipoUsuario;
use CineLivro\Helpers\Utils;
use CineLivro\Helpers\Validacoes;
use CineLivro\Models\Usuario;
use CineLivro\Services\UsuarioServico;

require_once "../vendor/autoload.php";

ControleDeAcesso::exigirLogin();

$usuarioServico = new UsuarioServico();

$dados = $usuarioServico->buscarPorId($_SESSION['id']);

if (isset($_POST["atualizar"])) {
    try {
        $nome = Utils::sanitizar($_POST["nome"]);
        Validacoes::validarNome($nome);

        $email = Utils::sanitizar($_POST["email"], 'email');
        Validacoes::validarEmail($email);

        $senhaBruta = $_POST["senha"];
        $senha = empty($senhaBruta) ? $dados["senha"] : Utils::verificarSenha($senhaBruta, $dados["senha"]);

        $data_nascimento = Utils::formataData($_POST["data_nascimento"]);
        Validacoes::validarDataNascimento($data_nascimento);

        $tipo = TipoUsuario::from($dados["tipo"]);

        $id = $_SESSION['id'];

        $usuario = new Usuario($nome, $email, $senha, $data_nascimento, $tipo, $id);
        $usuarioServico->atualizar($usuario);

        $_SESSION["nome"] = $nome;

        header("location:index.php?perfil_atualizado");
        exit;
    } catch (Throwable $erro) {
        $mensagemDeErro = "Erro ao atualizar perfil.";
        Utils::registrarLog($erro);
    }
}

require_once "../includes/cabecalho-admin.php";

?>

<div class="row">
    <article class="col-12 bg-white rounded shadow my-1 py-4">

        <h2 class="text-center">
            Atualizar meus dados
        </h2>

        <?php if (!empty($mensagemDeErro)) : ?>
            <div class="alert alert-danger text-center" role="alert">
                <?= $mensagemDeErro ?>
            </div>
        <?php endif; ?>

        <form class="mx-auto w-75" action="" method="post" id="form-atualizar" name="form-atualizar">
            <input type="hidden" name="id" value="<?= $dados["id"] ?? '' ?>">

            <div class="mb-3">
                <label class="form-label" for="nome">Nome:</label>
                <input value="<?= $dados["nome"] ?? '' ?>" class="form-control" type="text" id="nome" name="nome">
            </div>

            <div class="mb-3">
                <label class="form-label" for="email">E-mail:</label>
                <input value="<?= $dados["email"] ?? '' ?>" class="form-control" type="email" id="email" name="email">
            </div>

            <div class="mb-3">
                <label class="form-label" for="senha">Senha:</label>
                <input class="form-control" type="password" id="senha" name="senha" placeholder="Preencha apenas se for alterar">
            </div>

            <button class="btn btn-primary" name="atualizar"><i class="bi bi-arrow-clockwise"></i> Atualizar</button>
        </form>

    </article>
</div>

<?php
require_once "../includes/rodape-admin.php";
?>