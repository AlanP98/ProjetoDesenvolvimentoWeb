<?php
	$file = '../config.php';

	if (file_exists($file)) {
		require_once $file;
	}
?>

<div class="jumbotron">
	<h1 class="">Desenvolvimento de sistemas para internet</h1>
	<p class="lead mt-5">Projeto desenvolvido na disciplina de Desenvolvimento de Sistemas para Internet do Curso Tecnólogo de Análise e Desenvolvimento de Sistemas</p>
	<p class="lead">Instituto Federal de Educação Ciência e Tecnologia do Rio Grande do Sul, Bento Gonçalves.</p>
	<p class="lead">Alan Possamai, 2018.</p>
	<hr class="my-4">

	<?php if (!Authenticator::isLogged()) {  ?>

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

		<p class="mt-5"><strong>O exercício tem como objetivo simular o desenvolvimento de sistemas no meio corporativo, onde deve ser considerado o resultado esperado pelo cliente, além de uma codificação clara e de fácil manutenção para a própria equipe de desenvolvimento.</strong></p>
		<p>O desenvolvimento parte de um código já estabelecido, e deve ser incrementado para atender as necessidades solicitadas.</p>
		<p>O exercício está separado por níveis incrementais, onde só é possível avançar com a resolução do anterior.</p>
		<ul class="mt-3">
			<li>O cliente necessita que os dados das pessoas sejam exportados em formato texto, sendo uma linha para cada pessoa, separando seus valores por ';' e incluindo na primeira linha a descrição "Pessoas exportadas:”</li>
			<li>A empresa acabou de vender o sistema para um um novo cliente, e esse precisa que seus dados referentes a pessoas sejam exportados em formato json. Pesquise como é esse formato e como essa informação pode ser gerada no php.</li>
			<li>Em uma nova exigência governamental, todos os clientes, além de pessoas, devem exportar na sequência todos os produtos cadastrados, respeitando o formato de exportação que cada cliente já exporta. Os valores exigidos são "NumeroRegistro” e "Descricao”.</li>
			<li>Proponha uma melhoria de código com o objetivo de facilitar novos formatos de exportação e novas inclusões de dados.</li>
		</ul>

		<p class="mt-5"><strong>A situação atual de nosso sistema é que a partir de um parâmetro é possível exportar clientes e produtos em formato texto ou json. Pois bem, vamos precisar avançar no desenvolvimento desse sistema</strong></p>
		<ul class="mt-3">
			<li>Precisamos implementar um recurso backend (código no servidor) que permita realizar as funções básicas de cadastro tanto de cliente como de produto</li>
			<ul>
				<li>Buscar por número do registro</li>
				<li>Buscar todos</li>
				<li>Inserir novo</li>
				<li>Atualizar</li>
				<li>Excluir</li>
			</ul>
			<li>Seja possível identificar o sexo da pessoa</li>
			<li>Não seja permitido a inserção de pessoas sem o número de registro e um nome</li>
			<li>Não seja permitido a inserção de produtos sem o número de registro e uma descrição</li>
			<li>Alteração técnica: Garanta que todos os dados armazenados, estejam encapsulados, ou seja só seja possível acessá-los a partir das funções definidas no requisito 1</li>
			<li>Precisamos controlar o número de instâncias de objetos que acessarão os dados. Implemente uma solução que seja possível controlar o número de instâncias possíveis da classe onde estão todos os dados. O ideal é que seja possível criar apenas uma única instância dessa classe</li>
		</ul>

		<p class="mt-5"><strong>A partir da aplicação web já desenvolvida em aula que contempla: a adição de produtos e um mecanismo de autenticação do usuário administrador, implemente os próximos requisitos conforme as descrições das estórias do cliente.</strong></p>
		<ul class="mt-3">
			<li>Eu gostaria que o site, além da possibilidade de incluir novos produtos, pudesse editar o conteúdo de um produto já cadastrado e ainda a opção de excluí-lo do sistema;</li>
			<li>O número do registro do produto deve ser validado para que não seja digitado errado tanto no cadastro, quanto na edição. A verificação do número é a seguinte: o número é formado por 6 dígitos numéricos sendo que o sexto é um dígito verificador (DV); O DV é o resultado obtido a partir do resto da divisão da soma dos cinco primeiros dígitos por nove, exceto quando o resto dessa divisão seja zero, nesse caso o DV é nove. O programa deve mostrar uma mensagem indicando quando o código é inválido e não permitir o cadastro;</li>
			<li>Quando adicionei um produto com o número errado, o programa me avisou disso e apagou a descrição do meu produto. Regra para todos os cadastros: Eu gostaria que quando o sistema mostrar alguma mensagem de erro na tela, mantivesse as informações digitadas anteriormente.</li>
			<li>Eu gostaria de cadastrar as pessoas no site, informando nome e e-mail;</li>
			<li>Quero dar acesso ao site para algumas das pessoas cadastradas, para isso gostaria de cadastrar um usuário e uma senha para algumas delas. Com isso feito, quero que elas mesmas possam alterar seus dados (nome, e-mail, usuário e senha);</li>
			<li>Gostaria que o sistema obrigasse o usuário a trocar de senha na primeira vez que ele se autenticasse, para evitar que eu saiba da senha de todos.</li>
			<li>Gostaria de não permitir o acesso a determinadas páginas, por determinados usuários. Penso em algo que pudesse escolher o perfil do usuário no momento do seu cadastro: convidado (nível0) que poderia apenas visualizar a lista de pessoas e produtos cadastrados; o gestor (nível1) que poderia, além das permissões do nível 0, cadastrar pessoas e produtos; e o administrador (adm) que seria capaz de, além das permissões do nível 0 e 1, registrar novos usuários. O usuário com perfil administrador será o único capaz de alterar o perfil dos demais usuários. Lembrando: todos os usuários pode alterar os seus dados cadastrais (nome, email, usuário e senha).</li>
			<li>O sistema permite que o usuário administrador restrinja suas próprias permissões. O que deixa o sistema inacessível!!! O sistema não pode permitir que não haja nenhum administrador ativo. Para fins de teste, mantenha fixo o usuário 'admin' senha 'admin' com permissão total a aplicação.</li>
		</ul>
	</div>

	<?php } ?>
</div>