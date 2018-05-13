<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8"/>
	<title>Login - Desenvolvimento Web</title>

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

		if (isLogged()) {
			header('Location: dashboard.php');
		} else {
			require_once DIR . "View/Forms/FormLogin.php";
		}
	?>
</body>
</html>