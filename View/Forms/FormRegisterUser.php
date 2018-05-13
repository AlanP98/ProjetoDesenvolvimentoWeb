<?php
	require_once '../../config.php';
	requireLogin();

	require_once DIR . '/View/Forms/FormRegisterPerson.php';
?>

<form id="formRegisterUser" action="javascript:void(0);">
	<input type="hidden" name="userId" id="userId" value="0">
	<div class="row">
		<div class="col-6">
			<div class="form-group">
				<label for="password">Senha</label>
				<input type="password" class="form-control" name="password" id="password">
			</div>
		</div>
		<div class="col-6">
			<div class="form-group">
				<label for="accessLevel">Nível de acesso</label>
				<select class="form-control" name="accessLevel" id="accessLevel">
					<option value="0">Convidado</option>
					<option value="1">Gestor</option>
					<option value="2">Administrador</option>
				</select>
			</div>
		</div>
	</div>
</form>

<?php if (isset($_GET['showBtns']) && $_GET['showBtns'] == true) { ?>
	<div class="mt-3">
		<button type="button" class="btn btn-primary" id="saveAccount">Salvar</button>
		<button type="button" class="btn btn-danger ml-3" id="deleteAccount">Excluir conta</button>
	</div>
<?php } ?>