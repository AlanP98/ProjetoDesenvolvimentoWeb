<?php
	require_once 'config.php';
	requireLogin();
?>

<div class="container-fluid">
	<ul class="nav nav-tabs bg-light">
		<span class="navbar-brand" href="#">Desenvolvimento Web</span>
		<li class="nav-item">
			<a class="nav-link active" href="#" id="activeBar">Home</a>
		</li>
		<li class="nav-item dropdown">
			<span class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Cadastros</span>
			<div class="dropdown-menu" value="cadastro">
				<a class="dropdown-item" href="#" id="registerUsers" value="usuários">Usuários</a>
				<div class="dropdown-divider"></div>
				<a class="dropdown-item" href="#" id="registerPersons" value="pessoas">Pessoas</a>
				<div class="dropdown-divider"></div>
				<a class="dropdown-item" href="#" id="registerProducts" value="produtos">Produtos</a>
			</div>
		</li>
		<li class="nav-item dropdown">
			<span class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Exportador</span>
			<div class="dropdown-menu" value="exportação">
				<a class="dropdown-item" href="#" id="exportPersons" value="pessoas">Pessoas</a>
				<div class="dropdown-divider"></div>
				<a class="dropdown-item" href="#" id="exportProducts" value="produtos">Produtos</a>
			</div>
		</li>
		<li class="nav-item mt-2" style="margin-left: 15%;">
			<div id="welcome">
				Bem-vindo&nbsp;
				<span class="text-primary">
					<?php echo (Session::getInstance()->getByKey('AUTHENTICATION'))->getUserName(); ?>
				</span>
				!
			</div>
		<li>
		<li class="nav-item dropdown ml-3">
			<span class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Minha conta</span>
			<div class="dropdown-menu" value="">
				<a class="dropdown-item" href="#" id="updateAccount" value="Dados cadastrais">Alterar dados</a>
				<div class="dropdown-divider"></div>
				<a class="dropdown-item" href="#" id="logout" value="logout">
					Sair <i class="fas fa-sign-out-alt ml-2"></i>
				</a>
			</div>
		</li>
	</ul>
	<div id="infos"></div>
	<div id="content" class="mt-5"></div>
</div>

<script type="text/javascript" src="View/Scripts/menu.js"></script>