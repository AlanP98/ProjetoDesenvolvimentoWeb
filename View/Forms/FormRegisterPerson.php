<button type="button" class="btn btn-outline-secondary mb-3" id="toggleForm">Abrir formulário</button>

<form id="registerPerson" style="display: none;" action="javascript:void(0);">
	<div class="form-group">
		<label for="recordNumber">Número de registro</label>
		<input type="number" class="form-control" name="recordNumber" id="recordNumber" aria-describedby="recordNumberHelp">
		<small id="recordNumberHelp" class="form-text text-muted">Somente números</small>
	</div>
	<div class="form-group">
		<label for="name">Nome</label>
		<input type="text" class="form-control" name="name" id="name">
	</div>
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

	<button type="button" class="btn btn-primary" id="register">Cadastrar</button>
</form>

<hr class="mt-5">

<h3>Clientes cadastrados</h3>

<table class="table table-hover table-light mt-3" id="listPersons">
	<thead>
		<tr>
			<th scope="col">Número de registro</th>
			<th scope="col">Nome</th>
			<th scope="col">Gênero</th>
		</tr>
	</thead>
	<tbody id="listPersonsContent"></tbody>
</table>

<script type="text/javascript" src="View/Scripts/FormPersons.js"></script>