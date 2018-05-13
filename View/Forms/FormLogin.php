<div class="text-center" style="margin-top:8%;">
	<form id="formLogin" class="form-signin" action="javascript:void(0);">
		<!-- <img class="mb-4" src="https://getbootstrap.com/assets/brand/bootstrap-solid.svg" alt="" width="72" height="72"> -->
		<h1 class="h3 mb-3 font-weight-normal">Login</h1>
		<label for="userName" class="sr-only">Usuário</label>
		<input type="text" id="userName" class="form-control" placeholder="Digite o seu usuário" required autofocus>
		<label for="password" class="sr-only">Senha</label>
		<input type="password" id="password" class="form-control mt-3" placeholder="Digite a senha" required>
		<button class="btn btn-lg btn-primary btn-block mt-5" type="submit" id="login">Entrar</button>
		<p class="mt-5 mb-3 text-muted">Alan Possamai, 2018 &copy;</p>
	</form>
</div>

<div id="message" style="display: none;"></div>

<script type="text/javascript" src="View/Scripts/FormLogin.js"></script>
