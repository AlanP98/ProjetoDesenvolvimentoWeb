<?php
	$file = '../../config.php';
	if (file_exists($file)) {
		require_once $file;
	}

	requireLogin();
?>

<form id="formRegisterPerson" action="javascript:void(0);">
	<div class="row">
		<div class="col-4">
			<div class="form-group">
				<label for="personId">Número de registro</label>
				<input type="number" class="form-control" name="personId" id="personId" aria-describedby="personIdHelp" readonly>
				<small id="personIdHelp" class="form-text text-muted">Número de registro interno</small>
			</div>
		</div>
		<div class="col-8">
			<div class="form-group">
				<label for="name">Nome</label>
				<input type="text" class="form-control" name="name" id="name">
			</div>
		</div>
		<div class="col-6">
			<div class="form-group">
				<label for="email">E-mail</label>
				<input type="email" class="form-control" name="email" id="email" onfocusout="checkEmail()">
				<small id="emailHelper" class="text-danger" style="display: none;">E-mail inválido.</small>
			</div>
		</div>
		<div class="col-6">
			<div class="form-group">
				<p>Gênero</p>
				<div class="form-check form-check-inline">
					<input class="form-check-input" type="radio" name="gender" id="man" value="M" checked>
					<label class="form-check-label" for="man">Masculino</label>
				</div>
				<div class="form-check form-check-inline">
					<input class="form-check-input" type="radio" name="gender" id="woman" value="W">
					<label class="form-check-label" for="woman">Feminino</label>
				</div>
				<div class="form-check form-check-inline">
					<input class="form-check-input" type="radio" name="gender" id="other" value="O">
					<label class="form-check-label" for="other">Outro</label>
				</div>
			</div>
		</div>
	</div>
</form>