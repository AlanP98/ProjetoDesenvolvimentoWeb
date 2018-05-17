function confirmLogout() {
	url = 'Service/Logout.php';

	createModal({
		'modalId': 'modalLogout',
		'body': 'Você deseja sair?',
		'smallModal': true,
		'textBtnOk': 'Sim',
		'textBtnCancel': 'Não',
		'classBtnOk': 'btn-danger',
		'fnOk': function () {
			logout();
		}
	});
}

function logout() {
	new Ajax().GET('Service/Logout.php');
	window.location.href = 'index.php';
}

function openRegistrationForm(options) {
	options = (options || {});
	options.updateContent = (typeof options.updateContent == 'undefined' ? true : options.updateContent);
	options.displayActions = (typeof options.displayActions == 'undefined' ? true : options.displayActions);

	$.when(getRegistrationForm(options.updateContent, options.displayActions), getUserData()).done(function (form, userData) {
		updateUserData(userData);

		if (typeof setTitle == 'function') {
			setTitle('Alterar cadastro');
		}

		if (typeof bindRegistrationEvents == 'function') {
			bindRegistrationEvents();
		}
	});
}

function bindRegistrationEvents() {
	$('#saveAccount').click(function () {
		saveUser('self');
	});

	$('#deleteAccount').click(function () {
		confirmDeleteUsers([], 1);
	});
}

function confirmDeleteUsers(ids, self) {
	createModal({
		'modalId': 'modalRemoveUser',
		'body': 'Você realmente deseja excluir este usuário?',
		'smallModal': true,
		'textBtnOk': 'Sim',
		'textBtnCancel': 'Não',
		'classBtnOk': 'btn-danger',
		'fnOk': function () {
			deleteUsers(ids, self);
		}
	});
}

function deleteUsers(ids, self) {
	if (!Array.isArray(ids)) {
		ids = [ids];
	}

	var data = { 'ids': ids };
	if (self) {
		data.self = true;
	}

	var ajax = new Ajax({
		'dataType': 'json',
		alwaysFn: function (response) {
			destroyModal('modalRemoveUser');

			if (!displayErrors(response)) {
				if (self) {
					logout();
				} else {
					createAlert({
						'alertType': 'success',
						'title': 'Sucesso',
						'msg': 'Usuário excluído!'
					});
				}
			}

			list();
		}
	});

	ajax.DELETE('Service/DeleteUser.php', data);
}

function saveUser(user) {
	var messages = [];

	switch (user) {
		case 'self':
		case 'firstAccess':
			messages[0] = 'Atualizar cadastro';
			messages[1] = 'Os seus dados cadastrais serão atualizados. Você confirma a ação?';
			messages[2] = 'Seus dados cadastrais foram atualizados com sucesso!';
			break;

		case 'new':
			messages[0] = 'Vincular usuário';
			messages[1] = 'Um perfil de acesso será cadastrado para a pessoa. Você confirma a ação?';
			messages[2] = 'Perfil de acesso cadastrado com sucesso!';
			break;

		default:
			messages[0] = 'Atualizar dados do usuário';
			messages[1] = 'O perfil será atualizado. Você confirma a ação?';
			messages[2] = 'Perfil atualizado com sucesso!';
			break;
	}

	createModal({
		'modalId': 'modalSaveAccount',
		'title': messages[0],
		'body': messages[1],
		'textBtnOk': 'Sim',
		'classBtnOk': 'btn-success',
		'fnOk': function () {
			var userData = getFormData($('#formRegisterUser'));
			var personData = getFormData($('#formRegisterPerson'));
			var data = $.extend({}, userData, personData);
			if (user == 'firstAccess') {
				data.firstAccess = true;
			}

			var ajax = new Ajax({
				'dataType': 'json',
				'alwaysFn': function (response) {
					destroyModal('modalSaveAccount');
					if (!displayErrors(response)) {
						destroyModal('userPersonForm');
						if (user == 'firstAccess') {
							window.location.href = 'dashboard.php';
						} else {
							createAlert({
								'alertType': 'success',
								'title': 'Sucesso',
								'msg': messages[2]
							});
						}
					}

					if (typeof list == 'function') {
						list();
					}
				}
			});

			ajax.POST('Service/RegisterUser.php', data);
		}
	});
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
	$('#idUser').val(userData.idUser);
	$('#name').val(userData.name);
	$('input[name=gender][value=' + userData.gender + ']').prop('checked', true);

	$('#email').val(userData.email);
	$('#userName').val(userData.userName);
	$('#password').val(userData.password || '');
	$('#confirmPassword').val(userData.password || '');
	$('#accessLevel').val(userData.accessLevel || 0);

	if (userData.id > 0) {
		$('#accessLevel').attr('disabled', true);
	}
}

function getRegistrationForm(updateContent, displayActions) {
	var deferred = $.Deferred();
	var ajax = new Ajax({
		alwaysFn: function (response) {
			if (response.status && response.status != 200) {
				createAlert({ 'title': 'Ops!', 'msg': 'Ocorreu um erro...' + response.responseText });
				deferred.fail(response);
			} else {
				if (updateContent == true) {
					var content = '<div class="container">' + response + '</div>';
					$('#content').html('');
					$('#content').append(content);
				}

				deferred.resolve(response);
			}
		}
	});

	ajax.GET('View/Forms/FormRegisterUser.php', { 'displayActions': (displayActions || 0) });
	return deferred.promise();
}

function checkPwds() {
	if ($('#password').val() != $('#confirmPassword').val()) {
		$('#confirmPassword, #password').addClass('is-invalid');
		$('#pwdHelper').show();
	} else {
		$('#confirmPassword, #password').removeClass('is-invalid');
		$('#pwdHelper').hide();
	}
}

function checkEmail() {
	var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;

	if (regex.test($('#email').val())) {
		$('#email').removeClass('is-invalid');
		$('#emailHelper').hide();
	} else {
		$('#email').addClass('is-invalid');
		$('#emailHelper').show();
	}
}