<?php
require_once "../vendor/autoload.php";

use CineLivro\Auth\ControleDeAcesso;
use CineLivro\Services\UsuarioServico;

ControleDeAcesso::exigirAdmin();

$usuarioServico = new UsuarioServico();
$listaDeUsuarios = $usuarioServico->listarTodos();
?>
<article class="col-12 bg-white rounded shadow my-1 py-4">

	<h2 class="text-center">
		Usuários <span class="badge bg-dark"> <?= count($listaDeUsuarios) ?> </span></h2>

	<p class="text-center mt-5">
		<a class="btn btn-primary" href="usuario-insere.php">
			<i class="bi bi-plus-circle"></i>
			Inserir novo usuário</a>
	</p>

	<div class="table-responsive">

		<table class="table table-hover">
			<thead class="table-light">
				<tr>
					<th>Nome</th>
					<th>E-mail</th>
					<th>senha</th>
					<th>data_nascimento</th>
					<th>Tipo</th>
					<th class="text-center">Ações</th>
				</tr>
			</thead>

			<tbody>

				<?php foreach ($listaDeUsuarios as $dadosUsuario) { ?>
					<tr>
						<td> <?= $dadosUsuario['nome'] ?> </td>
						<td> <?= $dadosUsuario['email'] ?> </td>
						<td> <?= $dadosUsuario['senha'] ?> </td>
						<td> <?= $dadosUsuario['data_nascimento'] ?> </td>
						<td> <?= $dadosUsuario['tipo'] ?> </td>
						<td class="text-center">
							<a class="btn btn-warning"
								href="usuario-atualiza.php?id=<?= $dadosUsuario['id'] ?>">
								<i class="bi bi-pencil"></i> Atualizar
							</a>

							<a class="btn btn-danger excluir"
								href="usuario-exclui.php?id=<?= $dadosUsuario['id'] ?>">
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