<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8"/>
	<title>Atualizar dados - Desenvolvimento Web</title>

	<!-- Bootstrap core CSS -->
	<link href="View/Includes/dist/css/bootstrap.min.css" rel="stylesheet">

	<!-- Bootstrap core JavaScript -->
	<script type="text/javascript" src="View/Includes/js/jquery-3.2.1.js"></script>
	<script src="View/Includes/assets/js/vendor/popper.min.js"></script>
	<script src="View/Includes/dist/js/bootstrap.min.js"></script>

	<!-- Font Awesome Free 5.0.10 -->
	<script defer src="View/Includes/fontawesome/fontawesome-all.js"></script>

	<!-- Own project scripts -->
	<script type="text/javascript" src="View/Scripts/utils.js"></script>

	<!-- Own project style sheets -->
	<link rel="stylesheet" type="text/css" href="View/Styles/stylesheet.css">

</head>
<body>
	<?php
		require_once "config.php";
		requireLogin();
	?>

	<div class="container">
		<div class="alert alert-warning">
			<strong>Este é o seu primeiro login!</strong><br>
			<span>É importante que você atualize seus dados, principalmente a senha.</span>
		</div>

		<div class="mt-5">
			<i class="far fa-check-circle text-success ml-5" style="font-size: 50px; cursor: pointer;" data-toggle="tooltip" data-placement="bottom" title="Atualizar meus dados" onclick="saveUser('self')"></i>
			<i class="far fa-arrow-alt-circle-right text-warning ml-5" style="font-size: 50px; cursor: pointer;" data-toggle="tooltip" data-placement="bottom" title="Pular esta etapa"></i>
			<i class="fas fa-user-times text-danger ml-5" style="font-size: 50px; cursor: pointer;" data-toggle="tooltip" data-placement="bottom" title="Excluir minha conta" onclick="deleteAccount()"></i>
			<i class="fas fa-power-off ml-5 text-secondary" style="font-size: 50px; cursor: pointer;" data-toggle="tooltip" data-placement="bottom" title="Encerrar sessão" onclick="confirmLogout()"></i>
		</div>

		<div id="infos"></div>
		<div id="content" class="mt-5"></div>
	</div>

	<script type="text/javascript" src="View/Scripts/UserSharedFunctions.js"></script>
	<script>
		$(function() {
			openRegistrationForm({'displayActions': false});
			initTooltips();
		});
	</script>
</body>
</html>