<?php
	require_once '../../config.php';
	Authenticator::requireLogin();
?>

<form id="formExportPerson" action="javascript:void(0);">
	<div class="form-group">
		<p>Escolha o formato para exportação</p>
		<div class="form-check form-check-inline">
			<input class="form-check-input" type="radio" name="exportationType" id="json" value="json" checked>
			<label class="form-check-label" for="json">JSON</label>
		</div>
		<div class="form-check form-check-inline">
			<input class="form-check-input" type="radio" name="exportationType" id="csv" value="csv">
			<label class="form-check-label" for="csv">CSV</label>
		</div>
	</div>

	<button type="button" class="btn btn-success mb-3" id="btnExportPersons">Exportar pessoas</button>
</form>

<div class="form-group mt-4">
	<label for="result">Resultado da exportação</label>
	<div class="form-control editable" rows="5" id="result" contenteditable="true"></div>
</div>

<script type="text/javascript" src="View/Scripts/ExportPersons.js"></script>