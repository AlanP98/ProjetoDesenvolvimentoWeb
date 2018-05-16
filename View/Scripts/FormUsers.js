$(function () {
	list();

	$('#toggleFilters').click(function () {
		toggleForm($('#filters'), $('#toggleFilters'), 'filtros');
	});

	$('#registerUser').click(function () {
		openRegisterForm();
	});

	$('#search').click(function () {
		list();
	});

	$('#clearFilters').click(function () {
		$('#filters input').val('');
		$('#filters select').val('');
		list();
	});

});

function list() {
	var ajax = new Ajax({
		dataType: 'json',
		alwaysFn: function (response) {
			if (!displayErrors(response)) {
				renderTable(response);
			}
		}
	});

	ajax.GET('Service/ListUsers.php', {
		'userName': $('#filterUserName').val(),
		'name': $('#filterName').val(),
		'accessLevel': $('#filterAccessLevel').val()
	});
}


function save(data) {
	var ajax = new Ajax({
		dataType: 'json',
		alwaysFn: function (response) {
			list();

			if (!displayErrors(response)) {
				destroyModal('modalRegisterUser');
				createAlert({
					'alertType': 'success',
					'title': 'Sucesso',
					'msg': 'Usuário ' + (data.personId > 0 ? 'atualizado!' : 'adicionado!')
				});
			}
		}
	});

	ajax.POST('Service/RegisterUser.php', data);
}

function renderTable(users) {
	$('#listUsersContent').html('');

	var content = getContentEmptySearch(users);
	if (content) {
		$('#listUsers').hide();
		$('#resultSearch').html(content);
		return false;
	} else {
		$('#listUsers').show();
		$('#resultSearch').html('');
	}

	$.each(users, function (i, user) {
		$('#listUsersContent').append(
			$('<tr>').append(
				$('<td>', { 'html': user.userName }),
				$('<td>', { 'html': user.name }),
				$('<td>', { 'html': parseAccessLevel(user.accessLevel) }),
				$('<td>').append(
					$('<i>', { 'class': 'far fa-edit', 'color': 'green', 'cursor': 'pointer', 'data-toggle': 'tooltip', 'data-placement': 'top', 'title': 'Editar usuário', 'onClick': 'updateForm(' + user.id + ')' }),
					$('<i>', { 'class': 'ml-3 far fa-trash-alt', 'color': '#ff4949ba', 'cursor': 'pointer', 'data-toggle': 'tooltip', 'data-placement': 'top', 'title': 'Excluir usuário', 'onClick': 'confirmDeleteUsers(' + user.id + ')' })
				)
			)
		);
	});

	initTooltips();
}

function openRegisterForm(idUser) {
	var ajax = new Ajax({
		alwaysFn: function(response) {
			createModal({
				'modalId': 'modalRegisterUser',
				'title': (idUser ? 'Atualizar' : 'Cadastrar') + ' usuário',
				'body': response,
				'largeModal': true,
				'textBtnOk': (idUser ? 'Atualizar' : 'Salvar'),
				'classBtnOk': (idUser ? 'btn-primary' : 'btn-success'),
				'fnOk': function () {
					var userData = getFormData($('#formRegisterUser'));
					var personData = getFormData($('#formRegisterPerson'));
					var data = $.extend({}, userData, personData);
					save(data);
				}
			});
		}
	});

	ajax.GET('View/Forms/FormRegisterUser.php');
}

function updateForm(idUser) {
	var data = { 'id': idUser };
	var ajax = new Ajax({
		'dataType': 'json',
		'beforeSendFn': function () {
			openRegisterForm(idUser);
		},
		'alwaysFn': function (response) {
			if (!displayErrors(response)) {
				populateForm(response);
			}
		}
	});

	ajax.GET('Service/ListUsers.php', data);
}

function populateForm(user) {
	setTimeout(function () {
		updateUserData(user);
	}, 500);
}

function parseAccessLevel(accessLevel) {
	switch (accessLevel) {
		case '1':
			return 'Gestor';

		case '2':
			return 'Administrador';

		default:
			return 'Convidado';
	}
}