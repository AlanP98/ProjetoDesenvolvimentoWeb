<div class="jumbotron">
	<h1 class="">Desenvolvimento de sistemas para internet</h1>
	<p class="lead">Projeto desenvolvido juntamente à cadeira de Desenvolvimento de Sistemas para Internet, IFRS-BG.</p>
	<p class="lead">Alan Possamai, 2018.</p>
	<hr class="my-4">
	<p>O projeto também pode ser acessado através do repositório do GitHub</p>
	<a class="btn btn-primary btn-xl" href="https://github.com/AlanP98/ProjetoDesenvolvimentoWeb" target="_blank" role="button">
		Acessar GitHub&ensp;
		<i class="fab fa-github"></i>
	</a>
</div>

<div id="intro" class="box generalbox"><div class="no-overflow" id="yui_3_17_2_3_1524261701872_98"><p>Exercício 2</p><p>Continuação do Exercício 1.</p><p>Descrição:</p><p id="yui_3_17_2_3_1524261701872_102">A situação atual de nosso sistema é que a partir de um parâmetro é possível exportar clientes e produtos em formato texto ou json. Pois bem, vamos precisar avançar no desenvolvimento desse sistema;</p><h1>Nível 1</h1><h4>Requisito 1</h4><h2></h2><p id="yui_3_17_2_3_1524261701872_97">Precisamos implementar um recurso backend (código no servidor) que permita realizar as funções básicas de cadastro tanto de cliente como de produto:</p><p></p><ul id="yui_3_17_2_3_1524261701872_105"><li id="yui_3_17_2_3_1524261701872_104"><span style="text-indent: -18pt;" id="yui_3_17_2_3_1524261701872_103">Buscar por número do registro;</span><br></li><li><span style="text-indent: -18pt;">Buscar todos;</span><br></li><li><span style="text-indent: -18pt;">Inserir novo;</span><br></li><li><span style="text-indent: -18pt;">Atualizar;</span><br></li><li><span style="text-indent: -18pt;">Excluir;</span></li></ul>A recomendação é que esses recursos possam ser chamados posteriormente.<br><p></p><p id="yui_3_17_2_3_1524261701872_106">Observação: Lembre que todas alterações são incrementais, e após a conclusão de cada requisição, todas operações já implementadas devem continuar funcionando;</p><h4>Requisito 2</h4><h2></h2><p>Alterações simples:</p><p style="text-indent: -18pt;"></p><ol><li>Seja possível identificar o sexo da pessoa;<br></li><li>Não seja permitido a inserção de pessoas sem o número de registro e um nome;<br></li><li>Não seja permitido a inserção de produtos sem o número de registro e uma descrição;<br></li></ol><p></p><h1>Nível 2</h1><h4>Requisito 3</h4><h2></h2><p>Alteração técnica: Garanta que todos os dados armazenados, estejam encapsulados, ou seja só seja possível acessá-los a partir das funções definidas no requisito 1;</p><h4>Requisito 4</h4><h2></h2><p><span style="font-size: 11pt; line-height: 15.6933px; font-family: Calibri, sans-serif;">Precisamos controlar o número de instâncias de objetos que acessarão os dados. Implemente uma solução que seja possível controlar o número de instâncias possíveis da classe onde estão todos os dados. O ideal é que seja possível criar apenas uma única instância dessa classe;</span></p></div></div>
