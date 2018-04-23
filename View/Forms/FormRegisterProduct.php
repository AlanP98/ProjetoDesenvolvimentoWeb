<button type="button" class="btn btn-outline-secondary mb-3" id="toggleForm">Exibir formulário</button>

<form id="formRegisterProduct" style="display: none;" action="javascript:void(0);">
	<div class="form-group">
		<label for="recordNumber">Número de registro</label>
		<input type="number" class="form-control" name="recordNumber" id="recordNumber" aria-describedby="recordNumberHelp" placeholder="123...">
		<small id="recordNumberHelp" class="form-text text-muted">Somente números</small>
	</div>
	<div class="form-group">
		<label for="description">Descrição</label>
		<input type="text" class="form-control" name="description" id="description" placeholder="Descrição">
	</div>

	<button type="button" class="btn btn-primary" id="register">Cadastrar</button>
</form>

<hr class="mt-5">

<h3>Produtos cadastrados</h3>

<span id="resultSearch"></span>
<table class="table table-hover table-light mt-3" id="listProducts">
	<thead>
		<tr>
			<th scope="col">Número de registro</th>
			<th scope="col">Descrição</th>
			<th scope="col"></th>
		</tr>
	</thead>
	<tbody id="listProductsContent"></tbody>
</table>

<script type="text/javascript" src="View/Scripts/FormProducts.js"></script>