<?php
	require_once '../../config.php';
	requireLogin();
?>

<form id="formRegisterProduct" action="javascript:void(0);">
	<input type="hidden" name="productId" id="productId">
	<div class="row">
		<div class="col-10">
			<div class="form-group">
				<label for="recordNumber">Número de registro</label>
				<input type="number" class="form-control" name="recordNumber" id="recordNumber" aria-describedby="recordNumberHelp" maxlength="6">
				<small id="recordNumberHelp" class="form-text text-muted">Somente números</small>
			</div>
		</div>
		<div class="col-2">
			<button type="button" class="btn btn-outline-primary text-right ml-3" id="generateRecordNumber" data-toggle="tooltip" data-placement="top" title="Gerar nro registro" onclick="setRandomRecordNumber()" style="margin-top: 35px;">
				<i class="fas fa-calculator"></i>
			</button>
		</div>
	</div>

	<div class="form-group">
		<label for="description">Descrição</label>
		<input type="text" class="form-control" name="description" id="description" placeholder="Descrição">
	</div>
</form>