<?php
	$file = '../config.php';

	if (file_exists($file)) {
		require_once $file;
	}
?>

<div class="jumbotron">
	<h1 class="">Desenvolvimento de sistemas para internet</h1>
	<p class="lead">Projeto desenvolvido juntamente à cadeira de Desenvolvimento de Sistemas para Internet, IFRS-BG.</p>
	<p class="lead">Alan Possamai, 2018.</p>
	<hr class="my-4">

	<?php if (!isLogged()) {  ?>

	<div id="actionBtns">
		<a class="btn btn-success btn-xl" href="login.php" role="button">
			Entrar&ensp;
			<i class="fas fa-sign-in-alt"></i>
		</a>
		<a class="btn btn-primary btn-xl ml-3" href="https://github.com/AlanP98/ProjetoDesenvolvimentoWeb" target="_blank" role="button">
			Acessar GitHub&ensp;
			<i class="fab fa-github"></i>
		</a>
	</div>

	<?php } else { ?>

	<div id="projectRequirements" style="text-align:justify;">
		<h3 class="mt-5">Requisitos do projeto</h3>
		<p>A partir da aplicação web já desenvolvida em aula que contempla: a adição de produtos e um mecanismo de autenticação do usuário administrador, implemente os próximos requisitos conforme as descrições das estórias do cliente.</p>
		<ol class="mt-3">
			<li>Eu gostaria que o site, além da possibilidade de incluir novos produtos, pudesse editar o conteúdo de um produto já cadastrado e ainda a opção de excluí-lo do sistema;</li>
			<li>O número do registro do produto deve ser validado para que não seja digitado errado tanto no cadastro, quanto na edição. A verificação do número é a seguinte: o número é formado por 6 dígitos numéricos sendo que o sexto é um dígito verificador (DV); O DV é o resultado obtido a partir do resto da divisão da soma dos cinco primeiros dígitos por nove, exceto quando o resto dessa divisão seja zero, nesse caso o DV é nove. O programa deve mostrar uma mensagem indicando quando o código é inválido e não permitir o cadastro;</li>
			<li>Quando adicionei um produto com o número errado, o programa me avisou disso e apagou a descrição do meu produto. Regra para todos os cadastros: Eu gostaria que quando o sistema mostrar alguma mensagem de erro na tela, mantivesse as informações digitadas anteriormente.</li>
			<li>Eu gostaria de cadastrar as pessoas no site, informando nome e e-mail;</li>
			<li>Quero dar acesso ao site para algumas das pessoas cadastradas, para isso gostaria de cadastrar um usuário e uma senha para algumas delas. Com isso feito, quero que elas mesmas possam alterar seus dados (nome, e-mail, usuário e senha);</li>
			<li>Gostaria que o sistema obrigasse o usuário a trocar de senha na primeira vez que ele se autenticasse, para evitar que eu saiba da senha de todos.</li>
			<li>Gostaria de não permitir o acesso a determinadas páginas, por determinados usuários. Penso em algo que pudesse escolher o perfil do usuário no momento do seu cadastro: convidado (nível0) que poderia apenas visualizar a lista de pessoas e produtos cadastrados; o gestor (nível1) que poderia, além das permissões do nível 0, cadastrar pessoas e produtos; e o administrador (adm) que seria capaz de, além das permissões do nível 0 e 1, registrar novos usuários. O usuário com perfil administrador será o único capaz de alterar o perfil dos demais usuários. Lembrando: todos os usuários pode alterar os seus dados cadastrais (nome, email, usuário e senha).</li>
			<li>O sistema permite que o usuário administrador restrinja suas próprias permissões. O que deixa o sistema inacessível!!! O sistema não pode permitir que não haja nenhum administrador ativo. Para fins de teste, mantenha fixo o usuário 'admin' senha 'admin' com permissão total a aplicação.</li>
		</ol>
	</div>

	<?php } ?>
</div>