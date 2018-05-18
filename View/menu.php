<?php
	require_once 'config.php';
	Authenticator::requireLogin();
?>

<div class="container-fluid">
	<ul class="nav nav-tabs bg-light">
		<span class="navbar-brand" href="#">
			<i class="fas fa-code"></i>
			Desenvolvimento Web
		</span>
		<li class="nav-item">
			<a class="nav-link active" href="#" id="activeBar">Home</a>
		</li>
		<li class="nav-item dropdown">
			<span class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Cadastros</span>
			<div class="dropdown-menu" value="cadastro">

			<?php if (Authenticator::hasPermission('WRITE_USER')) { ?>
				<a class="dropdown-item" href="#" id="registerUsers" value="usuários">Usuários</a>
				<div class="dropdown-divider"></div>
			<?php } ?>

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
		<li class="nav-item dropdown">
			<span class="nav-link dropdown-toggle text-primary" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
				<i class="fas fa-user-circle"></i>
			</span>
			<div class="dropdown-menu" value="">
				<a class="dropdown-item text-success" href="#" id="updateAccount" value="Dados cadastrais">
					Atualizar cadastro <i class="far fa-id-card ml-2"></i>
				</a>
				<div class="dropdown-divider"></div>
				<a class="dropdown-item text-danger" href="#" id="logout" value="logout">
					Sair <i class="fas fa-sign-out-alt ml-2"></i>
				</a>
			</div>
		</li>
		<li class="nav-item mt-2">
			<div id="welcome" class="ml-2">
				Bem-vindo&nbsp;
				<span class="text-primary">
					<?php echo Session::getInstance()->getByKey('realName'); ?>
				</span>
				!
			</div>
		<li>
	</ul>
	<div id="infos"></div>
	<div id="content" class="mt-5"></div>
</div>

<script type="text/javascript" src="View/Scripts/Menu.js"></script>
<script type="text/javascript" src="View/Scripts/Registration.js"></script>