<?php

use CineLivro\Enums\TipoUsuario;
use CineLivro\Helpers\Utils;
use CineLivro\Helpers\Validacoes;
use CineLivro\Models\Usuario;
use CineLivro\Services\UsuarioServico;

require_once "../vendor/autoload.php";

$mensagemDeErro = "";
$usuarioServico = new UsuarioServico();

if(isset($_POST['cadastrar'])) {
    try {
        $nome = Utils::sanitizar($_POST["nome"]);
        Validacoes::validarNome($nome);

        $email = Utils::sanitizar($_POST["email"], 'email');
        Validacoes::validarEmail($email);

        $senhaBruta = $_POST["senha"];
        Validacoes::validarSenha($senhaBruta);
        $senha = Utils::codificarSenha($senhaBruta);

        $data_nascimento = Utils::formataData($_POST["data_nascimento"]);
		Validacoes::validarDataNascimento($data_nascimento);

		$tipoStr = $_POST["tipo"];
		Validacoes::validarTipo($tipoStr);
		$tipo = TipoUsuario::from($tipoStr);

		$usuario = new Usuario($nome, $email, $senha, $data_nascimento, $tipo);
		$usuarioServico->cadastrar($usuario);

		header("location:usuarios.php");
		exit;
    } catch (Throwable $erro) {
		$mensagemDeErro = $erro->getMessage();
	} catch (Throwable $erro) {
		$mensagemDeErro = "Erro ao cadastrar usuário.";
		Utils::registrarLog($erro);
	}
}

?>
<div class="row">
	<article class="col-12 bg-white rounded shadow my-1 py-4">

		<h2 class="text-center">
			Inserir novo usuário
		</h2>

		<?php if (!empty($mensagemErro)) : ?>
			<div class="alert alert-danger text-center" role="alert">
				<?= $mensagemErro ?>
			</div>
		<?php endif; ?>


		<form class="mx-auto w-75" action="" method="post" id="form-cadastrar" name="form-cadastrar">

			<div class="mb-3">
				<label class="form-label" for="nome">Nome:</label>
				<input class="form-control" type="text" id="nome" name="nome">
			</div>

			<div class="mb-3">
				<label class="form-label" for="email">E-mail:</label>
				<input class="form-control" type="email" id="email" name="email">
			</div>

			<div class="mb-3">
				<label class="form-label" for="senha">Senha:</label>
				<input class="form-control" type="password" id="senha" name="senha">
			</div>

            <div class="mb-3">
				<label class="form-label" for="data_nascimento">Data de Nascimento:</label>
				<input class="form-control" type="date" id="data_nascimento" name="data_nascimento">
			</div>

			<div class="mb-3">
				<label class="form-label" for="tipo">Tipo (usuario padrão é o padrão):</label>
				<select class="form-select" name="tipo" id="tipo">
					<option value=""></option>
					<option value="padrao" selected>padrao</option>
					<option value="admin">Administrador</option>
				</select>
			</div>

			<button class="btn btn-primary" id="cadastrar" name="cadastrar"><i class="bi bi-save"></i> Cadastrar</button>
		</form>

	</article>
</div>