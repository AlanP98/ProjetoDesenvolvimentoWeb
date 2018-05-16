$(function() {
	updateContext('<i class="fas fa-home mr-2"></i>Home', '');

	$('#registerUsers, #registerProducts, #registerPersons, #exportProducts, #exportPersons').click(function() {
		var objectType = $(this).attr('value');
		var action = $(this).parent().attr('value');
		updateContext(objectType, action);
	});

	$('#logout').click(function () {
		confirmLogout();
	});

	$('#updateAccount').click(function () {
		openRegistrationForm();
	});

	$('.navbar-brand').click(function() {
		updateContext('<i class="fas fa-home mr-2"></i>Home', '');
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
	$('#activeBar').html(title);
}

function getRequestUrl(objectType, action) {
	var url = '';

	switch(action) {
		case 'cadastro':
			url += 'View/Forms/List';
			break;
		case 'exportação':
			url += 'View/Forms/FormExport';
			break;
		default:
			url = 'View/home.php';
			break;
	}

	switch(objectType) {
		case 'usuários':
			url += 'Users.php';
			break;
		case 'produtos':
			url += 'Product.php';
			break;
		case 'pessoas':
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
		case 'account':
			return 'POST';
		case 'exportação':
			return 'GET';
		default:
			return 'GET';
	}
}