<?php
require_once "../vendor/autoload.php";

use CineLivro\Auth\ControleDeAcesso;
use CineLivro\Helpers\Utils;
use CineLivro\Services\UsuarioServico;

ControleDeAcesso::exigirAdmin();

$usuarioServico = new UsuarioServico();
$listaDeUsuarios = $usuarioServico->listarTodos();

require_once "../includes/cabecalho-admin.php";
?>
<div class="container my-5">
	<article class="col-12 bg-black rounded shadow py-4">

		<h2 class="text-center text-white">
			Usuários <span class="badge bg-gradient"> <?= count($listaDeUsuarios) ?> </span></h2>

		<p class="text-center mt-5">
			<a class="btn btn-primary" href="usuario-cadastra.php">
				<i class="bi bi-plus-circle"></i>
				Cadastrar novo usuário</a>
		</p>

		<div class="table-responsive">
			<table class="table table-hover">
				<thead class="table-light">
					<tr>
						<th>Nome</th>
						<th>E-mail</th>
						<th>Data de nascimento</th>
						<th>Tipo</th>
						<th class="text-center">Ações</th>
					</tr>
				</thead>

				<tbody>

					<?php foreach ($listaDeUsuarios as $dadosUsuario) { ?>
						<tr>
							<td> <?= $dadosUsuario['nome'] ?> </td>
							<td> <?= $dadosUsuario['email'] ?> </td>
							<td> <?= Utils::formataData($dadosUsuario['data_nascimento']) ?> </td>
							<td> <?= $dadosUsuario['tipo'] ?> </td>
							<td class="text-center">
								<a class="btn btn-warning" href="usuario-atualiza.php?id=<?= $dadosUsuario['id'] ?>">
									<i class="bi bi-pencil"></i> Atualizar
								</a>

								<a class="btn btn-danger excluir" href="usuario-exclui.php?id=<?= $dadosUsuario['id'] ?>" onclick="return confirm('Tem certeza que deseja excluir este Usuário?');">
									<i class="bi bi-trash"></i> Excluir
								</a>
							</td>
						</tr>
					<?php } ?>

				</tbody>
			</table>
		</div>
	</article>
</div>

<?php
require_once "../includes/rodape-admin.php";
?>