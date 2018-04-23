$(function() {
	list();

	$('#toggleForm').click(function() {
		toggleForm($('#formRegisterPerson'), $('#toggleForm'));
	});

	$('#register').click(function() {
		add(getFormData($('#formRegisterPerson')));
	});

});

function list() {
	var ajax = new Ajax({
		dataType: 'json',
		alwaysFn: function(response) {
			if (!displayErrors(response)) {
				renderTable(response);
			}
		}
	});

	ajax.GET('Service/ListPersons.php');
}

function add(data) {
	var ajax = new Ajax({
		dataType: 'json',
		alwaysFn: function(response) {
			displayErrors(response);
			list();
		}
	});

	ajax.POST('Service/RegisterPerson.php', data);
}

function deletePersons(ids) {
	if (!confirm('Deseja deletar o cliente?')) {
		return false;
	}

	if (!Array.isArray(ids)) {
		ids = [ids];
	}

	var data = {'ids': ids};
	var ajax = new Ajax({
		'dataType': 'json',
		alwaysFn: function (response) {
			if (!displayErrors(response)) {
				createAlert({
					'alertType': 'success',
					'title': 'Sucesso',
					'msg': 'Cliente excluído!'
				});
			}

			list();
		}
	});

	ajax.DELETE('Service/DeletePerson.php', data);
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

	$.each(persons, function(i, person) {
		$('#listPersonsContent').append(
			$('<tr>').append(
				$('<td>', {'html': person.recordNumber}),
				$('<td>', {'html': person.name}),
				$('<td>', {'html': getGender(person.gender)}),
				$('<td>').append(
					$('<i>', { 'class': 'fas fa-trash-alt', 'color': '#ff4949ba', 'cursor': 'pointer', 'onClick': 'deletePersons(' + person.id + ')'})
				)
			)
		);
	});
}

function getGender(gender) {
	switch(gender) {
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