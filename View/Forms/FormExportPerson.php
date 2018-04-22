<form id="exportPerson" action="javascript:void(0);">
	<div class="form-group">
		<p>Escolha o formato para exportação</p>
		<div class="form-check form-check-inline">
			<input class="form-check-input" type="radio" name="exportType" id="json" value="json" checked>
			<label class="form-check-label" for="json">JSON</label>
		</div>
		<div class="form-check form-check-inline">
			<input class="form-check-input" type="radio" name="exportType" id="csv" value="csv">
			<label class="form-check-label" for="csv">CSV</label>
		</div>
	</div>

	<button type="button" class="btn btn-success mb-3" id="exportPersons">Exportar pessoas</button>
</form>

<script type="text/javascript" src="View/Scripts/FormExportPersons.js"></script>