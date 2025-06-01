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

if (isset($_POST['cadastrar'])) {
	try {
		$nome = Utils::sanitizar($_POST["nome"]);
		Validacoes::validarNome($nome);

		$email = Utils::sanitizar($_POST["email"], 'email');
		Validacoes::validarEmail($email);

		$senhaBruta = $_POST["senha"];
		Validacoes::validarSenha($senhaBruta);
		$senha = Utils::codificarSenha($senhaBruta);

		$data_nascimento = $_POST["data_nascimento"];
		Validacoes::validarDataNascimento($data_nascimento);

		$tipoStr = $_POST["tipo"];
		Validacoes::validarTipo($tipoStr);
		$tipo = TipoUsuario::from($tipoStr);

		$usuario = new Usuario($nome, $email, $senha, $data_nascimento, $tipo);
		$usuarioServico->cadastrar($usuario);

		header("location:usuarios.php");
		exit;
	} catch (Throwable $erro) {
		$mensagemDeErro = "Erro ao cadastrar usuário.";
		Utils::registrarLog($erro);
	}
}

require_once "../includes/cabecalho-admin.php";

?>

<div class="container my-5">
	<div class="row">
		<article class="col-12 bg-dark rounded shadow py-4">

			<h2 class="text-center text-white">Cadastrar novo usuário</h2>

			<?php if (!empty($mensagemDeErro)) : ?>
				<div class="alert alert-danger text-center" role="alert">
					<?= $mensagemDeErro ?>
				</div>
			<?php endif; ?>

			<form class="mx-auto w-75" method="post" id="form-cadastrar">
				<div class="mb-3">
					<label class="form-label text-white" for="nome">Nome:</label>
					<input class="form-control" type="text" id="nome" name="nome">
				</div>

				<div class="mb-3">
					<label class="form-label text-white" for="email">E-mail:</label>
					<input class="form-control" type="email" id="email" name="email">
				</div>

				<div class="mb-3">
					<label class="form-label text-white" for="senha">Senha:</label>
					<input class="form-control" type="password" id="senha" name="senha">
				</div>

				<div class="mb-3">
					<label class="form-label text-white" for="data_nascimento">Data de Nascimento:</label>
					<input class="form-control" type="date" id="data_nascimento" name="data_nascimento">
				</div>

				<div class="mb-3">
					<label class="form-label text-white" for="tipo">Tipo:</label>
					<select class="form-select" name="tipo" id="tipo">
						<option value=""></option>
						<option value="padrão" selected>padrão</option>
						<option value="admin">Administrador</option>
					</select>
				</div>

				<button class="btn btn-primary" name="cadastrar">
					<i class="bi bi-save"></i> Cadastrar
				</button>
			</form>

		</article>
	</div>
</div>

<?php
require_once "../includes/rodape-admin.php";
?>