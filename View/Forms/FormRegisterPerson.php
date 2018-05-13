<?php
	require_once '../../config.php';
	requireLogin();
?>

<form id="formRegisterPerson" action="javascript:void(0);">
	<input type="hidden" name="personId" id="personId" value="0">
	<div class="row">
		<div class="col-4">
			<div class="form-group">
				<label for="recordNumber">Número de registro</label>
				<input type="number" class="form-control" name="recordNumber" id="recordNumber" aria-describedby="recordNumberHelp">
				<small id="recordNumberHelp" class="form-text text-muted">Somente números</small>
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
				<input type="email" class="form-control" name="email" id="email">
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