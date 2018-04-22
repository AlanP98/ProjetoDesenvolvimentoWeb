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
			if (response.error) {
				createAlert({
					'title': 'Aviso',
					'msg': response.msg
				});
			}

			renderTable(response);
		}
	});

	ajax.GET('Lists/PersonList.php');
}

function add(data) {
	var ajax = new Ajax({
		dataType: 'json',
		alwaysFn: function(response) {
			var errorMsg = '';
			if (response.status && response.status != 200) {
				errorMsg = response.responseText;
			} else if (response.error) {
				errorMsg = response.msg;
			}

			list();
			if (errorMsg) {
				createAlert({
					'title': 'Aviso',
					'msg': errorMsg
				});
			}
		}
	});

	ajax.POST('Register/RegisterPerson.php', data);
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
				$('<td>', {'html': getGender(person.gender)})
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