<?php
require_once "../vendor/autoload.php";

use CineLivro\Auth\ControleDeAcesso;
use CineLivro\Enums\TipoUsuario;
use CineLivro\Helpers\Utils;
use CineLivro\Helpers\Validacoes;
use CineLivro\Models\Usuario;
use CineLivro\Services\UsuarioServico;

ControleDeAcesso::exigirAdmin();

$mensagemDeErro = "";
$usuarioServico = new UsuarioServico();

$id = Utils::sanitizar($_GET["id"], 'inteiro');
$dados = $usuarioServico->buscarPorId($id);

if (empty($dados)) {
    Utils::alertaErro("Usuário não encontrado.");
    header("location:index.php");
    exit;
}

if (isset($_POST["atualizar"])) {
    try {
        $nome = Utils::sanitizar($_POST["nome"]);
        Validacoes::validarNome($nome);

        $email = Utils::sanitizar($_POST["email"], 'email');
        Validacoes::validarEmail($email);

        $senhaBruta = $_POST["senha"];
        $senha = empty($senhaBruta) ? $dados["senha"] : Utils::verificarSenha($senhaBruta, $dados["senha"]);

        $data_nascimento = $_POST["data_nascimento"];
        Validacoes::validarDataNascimento($data_nascimento);

        $tipoStr = $_POST["tipo"];
        Validacoes::validarTipo($tipoStr);
        $tipo = TipoUsuario::from($tipoStr);

        $usuario = new Usuario($nome, $email, $senha, $data_nascimento, $tipo, $id);
        $usuarioServico->atualizar($usuario);
        header("location:usuarios.php");
        exit;
    } catch (Throwable $erro) {
        $mensagemDeErro = "Erro ao atualizar usuário.";
        Utils::registrarLog($erro);
    }
}

require_once "../includes/cabecalho-admin.php";

?>
<div class="container my-5">
    <article class="col-12 bg-dark rounded shadow py-4">

        <h2 class="text-center text-white">
            Atualizar dados do usuário
        </h2>

        <?php if (!empty($mensagemDeErro)) : ?>
            <div class="alert alert-danger text-center" role="alert">
                <?= $mensagemDeErro ?>
            </div>
        <?php endif; ?>

        <form class="mx-auto w-75" action="" method="post" id="form-atualizar" name="form-atualizar">
            <input type="hidden" name="id" value="<?= $dados["id"] ?>" required>

            <div class="mb-3 text-white">
                <label class="form-label" for="nome">Nome:</label>
                <input class="form-control" type="text" id="nome" name="nome" value="<?= $dados['nome'] ?>" required>
            </div>

            <div class="mb-3 text-white">
                <label class="form-label" for="email">E-mail:</label>
                <input class="form-control" type="email" id="email" name="email" value="<?= $dados['email'] ?>" required>
            </div>

            <div class="mb-3 text-white">
                <label class="form-label" for="senha">Senha:</label>
                <input class="form-control" type="password" id="senha" name="senha" placeholder="Preencha apenas se for alterar">
            </div>

            <div class="mb-3 text-white">
                <label class="form-label" for="data_nascimento">Data de Nascimento:</label>
                <input class="form-control" type="date" id="data_nascimento" name="data_nascimento" value="<?= $dados['data_nascimento'] ?>" required>
            </div>

            <div class="mb-3 text-white">
                <label class="form-label" for="tipo">Tipo:</label>
                <select class="form-select" name="tipo" id="tipo" required>
                    <option value=""></option>

                    <option <?php if ($dados['tipo'] === 'padrão') echo " selected "; ?> value="padrão">Padrão</option>

                    <option <?php if ($dados['tipo'] === 'admin') echo " selected "; ?> value="admin">Administrador</option>

                </select>
            </div>

            <button class="btn btn-success" name="atualizar"><i class="bi bi-arrow-clockwise"></i> Atualizar</button>

            <a href="usuarios.php" class="btn btn-secondary">Cancelar</a>
        </form>

    </article>
</div>

<?php
require_once "../includes/rodape-admin.php";
?>