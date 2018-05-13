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
		'recordNumber': $('#filterRecordNumber').val(),
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
					'msg': 'Pessoa ' + (data.personId > 0 ? 'atualizado' : 'adicionado')
				});
			}
		}
	});

	ajax.POST('Service/RegisterPerson.php', data);
}

function deletePersons(ids) {
	if (!confirm('Deseja excluir a pessoa?')) {
		return false;
	}

	if (!Array.isArray(ids)) {
		ids = [ids];
	}

	var data = { 'ids': ids };
	var ajax = new Ajax({
		'dataType': 'json',
		alwaysFn: function (response) {
			if (!displayErrors(response)) {
				createAlert({
					'alertType': 'success',
					'title': 'Sucesso',
					'msg': 'Pessoa(s) excluída(s)!'
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
				},
				'fnAfterOpen': function () {
					if (personId) {
						$('#update').show();
					} else {
						$('#register').show();
					}
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
		$('#listPersonsContent').append(
			$('<tr>').append(
				$('<td>', { 'html': person.recordNumber }),
				$('<td>', { 'html': person.name }),
				$('<td>', { 'html': person.email }),
				$('<td>', { 'html': getGender(person.gender) }),
				$('<td>').append(
					$('<i>', { 'class': 'far fa-edit', 'color': 'green', 'cursor': 'pointer', 'data-toggle': 'tooltip', 'data-placement': 'top', 'title': 'Editar pessoa', 'onClick': 'updateForm(' + person.id + ')' }),
					$('<i>', { 'class': 'ml-3 far fa-trash-alt', 'color': '#ff4949ba', 'cursor': 'pointer', 'data-toggle': 'tooltip', 'data-placement': 'top', 'title': 'Excluir pessoa', 'onClick': 'deletePersons(' + person.id + ')' })
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

function populateForm(person) {
	setTimeout(function () {
		$('#recordNumber').attr('readonly', true);
		$('#personId').val(person.id);
		$('#recordNumber').val(person.recordNumber);
		$('#name').val(person.name);
		$('#email').val(person.email);
		$('input[name=gender][value=' + person.gender + ']').prop('checked', true);
	}, 500);
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