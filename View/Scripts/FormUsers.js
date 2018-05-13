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
	var data = {
		'userName': $('#filterUserName').val(),
		'name': $('#filterName').val(),
		'accessLevel': $('#filterAccessLevel').val()
	};

	var ajax = new Ajax({
		dataType: 'json',
		alwaysFn: function (response) {
			if (!displayErrors(response)) {
				renderTable(response);
			}
		}
	});

	ajax.GET('Service/ListUsers.php', data);
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
					'msg': 'Usuário ' + (data.personId > 0 ? 'atualizado' : 'adicionado')
				});
			}
		}
	});

	ajax.POST('Service/RegisterUser.php', data);
}

function deleteUsers(ids) {
	debug(ids);
	if (!confirm('Cuidado! Você realmente deseja excluir este usuário?')) {
		return false;
	}

	if (!Array.isArray(ids)) {
		ids = [ids];
	}

	var data = { 'ids': ids };
	var ajax = new Ajax({
		'dataType': 'json',
		alwaysFn: function (response) {
			if (response == true) {
				createAlert({
					'alertType': 'success',
					'title': 'Sucesso',
					'msg': 'Usuário excluído!'
				});
			} else {
				var msg = (response.errorMessage || response.responseText);
				createModal({
					'title': 'Não foi possível excluir',
					'hideBtnCanel': true,
					'textBtnOk': 'Fechar',
					'body': msg
				});
			}

			list();
		}
	});

	ajax.DELETE('Service/DeleteUser.php', data);
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
		debug(user);
		$('#listUsersContent').append(
			$('<tr>').append(
				$('<td>', { 'html': user.userName }),
				$('<td>', { 'html': user.name }),
				$('<td>', { 'html': parseAccessLevel(user.accessLevel) }),
				$('<td>').append(
					$('<i>', { 'class': 'far fa-edit', 'color': 'green', 'cursor': 'pointer', 'data-toggle': 'tooltip', 'data-placement': 'top', 'title': 'Editar usuário', 'onClick': 'updateForm(' + user.id + ')' }),
					$('<i>', { 'class': 'ml-3 far fa-trash-alt', 'color': '#ff4949ba', 'cursor': 'pointer', 'data-toggle': 'tooltip', 'data-placement': 'top', 'title': 'Excluir usuário', 'onClick': 'deleteUsers(' + user.id + ')' })
				)
			)
		);
	});

	initTooltips();
}

function openRegisterForm(userId) {
	var ajax = new Ajax({
		alwaysFn: function(response) {
			createModal({
				'modalId': 'modalRegisterUser',
				'title': (userId ? 'Atualizar' : 'Cadastrar') + ' usuário',
				'body': response,
				'largeModal': true,
				'textBtnOk': (userId ? 'Atualizar' : 'Salvar'),
				'classBtnOk': (userId ? 'btn-primary' : 'btn-success'),
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

function updateForm(userId) {
	var data = { 'id': userId };
	var ajax = new Ajax({
		'dataType': 'json',
		'beforeSendFn': function () {
			openRegisterForm(userId);
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

/*
<div class="bg-primary text-light m-4 text-center">
    <span>Adicione um perfil de acesso para essa pessoa</span><br>
    <span style="font-size: 14px;">O login para acesso será o e-mail da pessoa</span>
</div>
*/