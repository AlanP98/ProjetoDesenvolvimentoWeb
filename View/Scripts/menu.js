$(function() {
	updateContext('Home', '');

	$('#registerProducts, #registerPersons, #exportProducts, #exportPersons').click(function() {
		var objectType = $(this).attr('value');
		var action = $(this).parent().attr('value');
		updateContext(objectType, action);
	});

	$('.navbar-brand').click(function() {
		updateContext('Home', '');
	});

});

function updateContext(objectType, action) {
	setTitle(getTitle(objectType, action));
	var url = getRequestUrl(objectType, action);
	var method = getMethod(action);

	var ajax = new Ajax({
		alwaysFn: function(response) {
			$('#content').html('');
			if (response.status && response.status != 200) {
				createAlert({'title': 'Ops!', 'msg': 'Ocorreu um erro...' + response.responseText});
			} else {
				$('#content').append(response);
			}
		}
	});

	ajax.request(method, url);
}

function getTitle(objectType, action) {
	return (action[0] ? action[0].toUpperCase() + action.substring(1) + ' de ' : ' ') + objectType;
}

function setTitle(title) {
	$('#activeBar').text(title);
}

function getRequestUrl(objectType, action) {
	var url = '';

	switch(action) {
		case 'cadastro':
			url += 'View/Forms/FormRegister';
			break;
		case 'exportação':
			url += 'View/Forms/FormExport';
			break;
		default:
			url = 'View/home.php';
			break;
	}

	switch(objectType) {
		case 'produtos':
			url += 'Product.php';
			break;
		case 'clientes':
			url += 'Person.php';
			break;
		default:
			url = 'View/home.php';
			break;
	}

	return url;
}

function getMethod(action) {
	switch(action) {
		case 'cadastro':
			return 'POST';
		case 'exportação':
			return 'GET';
	}
}