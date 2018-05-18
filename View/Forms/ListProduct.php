<?php
	require_once '../../config.php';
	Authenticator::requireLogin();
?>

<button type="button" class="btn btn-outline-secondary mb-3" id="toggleFilters">Exibir filtros</button>
<button type="button" class="btn btn-outline-primary text-right ml-3 mb-3" id="registerProduct">Cadastrar produto</button>
<form id="filters" style="display:none;" action="javascript:void(0);">
	<h4>Filtrar resultados</h4>
	<div class="row">
		<div class="col-2">
			<div class="form-group">
				<label for="filterRecordNumber">Número de registro</label>
				<input type="number" class="form-control" id="filterRecordNumber">
			</div>
		</div>
		<div class="col-2">
			<div class="form-group">
				<label for="filterDescription">Descrição</label>
				<input type="text" class="form-control" id="filterDescription">
			</div>
		</div>
		<div class="col-8">
			<div class="form-group">
				<button type="button" class="btn btn-success" id="search" style="margin-top: 34px;">
					Filtrar&ensp;
					<i class="fas fa-filter"></i>
				</button>
				<button type="button" class="btn btn-primary ml-3" id="clearFilters" style="margin-top: 34px;">
					Limpar filtros&ensp;
					<i class="fas fa-eraser"></i>
				</button>
			</div>
		</div>
	</div>
</form>
<hr class="mb-5">

<h3>Produtos cadastrados</h3>
<span id="resultSearch"></span>
<div class="table-responsive">
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
</div>

<script type="text/javascript" src="View/Scripts/Products.js"></script>