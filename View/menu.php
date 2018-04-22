<div class="container-fluid">
	<ul class="nav nav-tabs bg-light">
		<span class="navbar-brand" href="#">Desenvolvimento Web</span>
		<li class="nav-item">
			<a class="nav-link active" href="#" id="activeBar">Home</a>
		</li>
		<li class="nav-item dropdown">
			<span class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Cadastros</span>
			<div class="dropdown-menu" value="cadastro">
				<a class="dropdown-item" href="#" id="registerPersons" value="clientes">Clientes</a>
				<div class="dropdown-divider"></div>
				<a class="dropdown-item" href="#" id="registerProducts" value="produtos">Produtos</a>
			</div>
		</li>
		<li class="nav-item dropdown">
			<span class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Exportador</span>
			<div class="dropdown-menu" value="exportação">
				<a class="dropdown-item" href="#" id="exportPersons" value="clientes">Clientes</a>
				<div class="dropdown-divider"></div>
				<a class="dropdown-item" href="#" id="exportProducts" value="produtos">Produtos</a>
			</div>
		</li>
	</ul>
	<div id="infos"></div>
	<div id="content" class="mt-5"></div>
</div>