$(function() {
	updateContext('Home', '');

	$('#registerUsers, #registerProducts, #registerPersons, #exportProducts, #exportPersons, #logout').click(function() {
		var objectType = $(this).attr('value');
		var action = $(this).parent().attr('value');
		updateContext(objectType, action);
	});

	$('#updateAccount').click(function () {
		openRegistrationForm();
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
		case 'logout':
			url = 'Service/Logout.php';
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

function openRegistrationForm(params) {
	$.when(getRegistrationForm(), getUserData()).done(function (form, userData) {
		updateUserData(userData);
	});
}

function getRegistrationForm() {
	var deferred = $.Deferred();
	setTitle('Alterar cadastro');

	var ajax = new Ajax({
		alwaysFn: function (response) {
			$('#content').html('');
			if (response.status && response.status != 200) {
				createAlert({ 'title': 'Ops!', 'msg': 'Ocorreu um erro...' + response.responseText });
				deferred.fail(response);
			} else {
				var content = '<div class="container">' + response + '</div>';
				$('#content').append(content);
				deferred.resolve(response);
			}
		}
	});

	ajax.GET('View/Forms/FormRegisterUser.php', {'showBtns': true});
	return deferred.promise();
}

function getUserData() {
	var deferred = $.Deferred();

	var ajax = new Ajax({
		'dataType': 'json',
		alwaysFn: function (response) {
			if (!displayErrors(response)) {
				deferred.resolve(response);
			}
		}
	});

	ajax.GET('Service/GetUserData.php');
	return deferred.promise();
}

function updateUserData(userData) {
	$('#personId').val(userData.id);
	$('#userId').val(userData.userId);
	$('#recordNumber').val(userData.recordNumber);
	$('#name').val(userData.name);
	$('#email').val(userData.email);
	$('input[name=gender][value=' + userData.gender + ']').prop('checked', true);

	$('#email').val(userData.userName);
	$('#password').val(userData.userName);
	$('#accessLevel').val(userData.accessLevel);
}