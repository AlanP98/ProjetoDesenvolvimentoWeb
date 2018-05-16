$(function () {
	list();

	$('#toggleFilters').click(function () {
		toggleForm($('#filters'), $('#toggleFilters'), 'filtros');
	});

	$('#registerPerson').click(function () {
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
		'name': $('#filterName').val(),
		'id': $('#filterId').val(),
		'gender': $('#filterGender option:selected').val()
	};

	var ajax = new Ajax({
		dataType: 'json',
		alwaysFn: function (response) {
			if (!displayErrors(response)) {
				renderTable(response);
			}
		}
	});

	ajax.GET('Service/GetPersons.php', data);
}

function save(data) {
	var ajax = new Ajax({
		dataType: 'json',
		alwaysFn: function (response) {
			list();

			if (!displayErrors(response)) {
				destroyModal('modalRegisterPersons');
				createAlert({
					'alertType': 'success',
					'title': 'Sucesso',
					'msg': 'Pessoa ' + (data.personId > 0 ? 'atualizada!' : 'adicionada!')
				});
			}
		}
	});

	ajax.POST('Service/RegisterPerson.php', data);
}

function confirmDeletePersons(ids) {
	createModal({
		'modalId': 'modalDeletePersons',
		'body': 'Você realmente deseja excluir esta pessoa?',
		'smallModal': true,
		'textBtnOk': 'Sim',
		'textBtnCancel': 'Não',
		'classBtnOk': 'btn-danger',
		'fnOk': function () {
			deletePersons(ids);
		}
	});
}

function deletePersons(ids) {
	if (!Array.isArray(ids)) {
		ids = [ids];
	}

	var data = { 'ids': ids };
	var ajax = new Ajax({
		'dataType': 'json',
		'alwaysFn': function (response) {
			destroyModal('modalDeletePersons');
			if (!displayErrors(response)) {
				createAlert({
					'alertType': 'success',
					'title': 'Sucesso',
					'msg': 'Pessoa excluída!'
				});
			}

			list();
		}
	});

	ajax.DELETE('Service/DeletePerson.php', data);
}

function openRegisterForm(personId) {
	var ajax = new Ajax({
		alwaysFn: function (response) {
			createModal({
				'modalId': 'modalRegisterPersons',
				'title': (personId ? 'Atualizar' : 'Cadastrar') + ' pessoa',
				'body': response,
				'largeModal': true,
				'textBtnOk': (personId ? 'Atualizar' : 'Salvar'),
				'classBtnOk': (personId ? 'btn-primary' : 'btn-success'),
				'fnOk': function () {
					save(getFormData($('#formRegisterPerson')));
				}
			});
		}
	});

	ajax.GET('View/Forms/FormRegisterPerson.php');
}

function renderTable(persons) {
	$('#listPersonsContent').html('');

	var content = getContentEmptySearch(persons);
	if (content) {
		$('#listPersons').hide();
		$('#resultSearch').html(content);
		return false;
	} else {
		$('#listPersons').show();
		$('#resultSearch').html('');
	}

	$.each(persons, function (i, person) {
		var btnTurnUser = $('<i>', { 'class': 'fas fa-user-plus', 'color': '#007bff', 'cursor': 'pointer', 'data-toggle': 'tooltip', 'data-placement': 'top', 'title': 'Conceder perfil de acesso', 'onClick': 'turnUser(' + person.id + ')' });
		var btnIconUser = $('<i>', { 'class': 'fas fa-user-times', 'color': '#ffb224d4', 'cursor': 'pointer', 'data-toggle': 'tooltip', 'data-placement': 'top', 'title': 'Remover perfil de acesso', 'onClick': 'confirmDeleteUsers(' + person.idUser + ')' });
		var appendBtn = (person.idUser > 0 ? btnIconUser : btnTurnUser);

		$('#listPersonsContent').append(
			$('<tr>').append(
				$('<td>', { 'html': person.id }),
				$('<td>', { 'html': person.name }),
				$('<td>', { 'html': person.email }),
				$('<td>', { 'html': getGender(person.gender) }),
				$('<td>').append(
					appendBtn,
					$('<i>', { 'class': 'ml-3 far fa-edit', 'color': 'green', 'cursor': 'pointer', 'data-toggle': 'tooltip', 'data-placement': 'top', 'title': 'Editar pessoa', 'onClick': 'updateForm(' + person.id + ')' }),
					$('<i>', { 'class': 'ml-3 far fa-trash-alt', 'color': '#ff4949ba', 'cursor': 'pointer', 'data-toggle': 'tooltip', 'data-placement': 'top', 'title': 'Excluir pessoa', 'onClick': 'confirmDeletePersons(' + person.id + ')' })
				)
			)
		);
	});

	initTooltips();
}

function updateForm(personId) {
	var data = { 'id': personId };
	var ajax = new Ajax({
		'dataType': 'json',
		'beforeSendFn': function () {
			openRegisterForm(personId);
		},
		alwaysFn: function (response) {
			if (!displayErrors(response)) {
				populateForm(response);
			}
		}
	});

	ajax.GET('Service/GetPersons.php', data);
}

function getPersonData(personId) {
	var deferred = $.Deferred();
	var ajax = new Ajax({
		'dataType': 'json',
		'alwaysFn': function (response) {
			if (displayErrors(response)) {
				deferred.fail();
			} else {
				deferred.resolve(response);
			}
		}
	});

	ajax.GET('Service/GetPersons.php', { 'id': personId });
	return deferred.promise();
}

function populateForm(person) {
	setTimeout(function () {
		$('#personId').val(person.id);
		$('#id').val(person.id);
		$('#name').val(person.name);
		$('#email').val(person.email);
		$('input[name=gender][value=' + person.gender + ']').prop('checked', true);
	}, 500);
}

function turnUser(personId) {
	createModal({
		'modalId': 'userPersonForm',
		'title': 'Vincular usuário à pessoa',
		'body': '',
		'largeModal': true,
		'textBtnOk': 'Salvar',
		'classBtnOk': 'btn-success',
		'fnOk': function () {
			saveUser('new');
			list();
		},
		'fnAfterOpen': function() {
			$.when(getRegistrationForm(), getPersonData(personId)).done(function (form, personData) {
				$('#modalBodyuserPersonForm').html('<div>' + form + '</div>');
				$('#formRegisterPerson').append(
					$('<div>', { 'class': 'bg-info text-light m-5 text-center'}).append(
						$('<div>', { 'class' : 'p-3' }).append(
							$('<span>', { 'text': 'Adicione um perfil de acesso para essa pessoa!' }),
							$('<br>'),
							$('<span>', { 'style': 'font-size: 14px', 'text': 'Preencha o nome de usuário, nível de acesso e senha.' })
						)
					)
				);

				updateUserData(personData);
			});
		}
	})
}

function getGender(gender) {
	switch (gender) {
		case 'M':
			return 'Masculino';
		case 'W':
			return 'Feminino';
		case 'O':
			return 'Outro';
		default:
			return '-';
	}
}