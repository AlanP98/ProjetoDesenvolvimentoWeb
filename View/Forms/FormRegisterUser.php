<?php
	$file = '../../config.php';
	if (file_exists($file)) {
		require_once $file;
	}

	Authenticator::requireLogin();
	require_once DIR . '/View/Forms/FormRegisterPerson.php';
?>

<form id="formRegisterUser" action="javascript:void(0);">
	<input type="hidden" name="idUser" id="idUser" value="0">
	<div class="row">
		<div class="col-6">
			<div class="form-group">
				<label for="userName">Nome de usuário</label>
				<input type="text" class="form-control" name="userName" id="userName">
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
		<div class="col-6">
			<div class="form-group">
				<label for="password">Senha</label>
				<input type="password" class="form-control" name="password" id="password" onfocusout="checkPwds()">
			</div>
		</div>
		<div class="col-6">
			<div class="form-group">
				<label for="confirmPassword">Confirme a senha</label>
				<input type="password" class="form-control" name="confirmPassword" id="confirmPassword" onfocusout="checkPwds()">
				<small id="pwdHelper" class="text-danger" style="display: none;">As senhas não conferem.</small>
			</div>
		</div>
	</div>
</form>

<?php if ((isset($_GET['displayActions'])) && ((bool) $_GET['displayActions'] === true)) { ?>
<div class="mt-3">
	<button type="button" class="btn btn-primary" id="saveAccount">Salvar</button>
	<button type="button" class="btn btn-danger ml-3" id="deleteAccount">Excluir conta</button>
</div>
<?php } ?>