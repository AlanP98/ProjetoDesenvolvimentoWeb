$(function() {

	$('#login').click(function() {
		login();
	});

});

function login() {
	var ajax = new Ajax({
		dataType: 'json',
		alwaysFn: function(response) {
			if (response.success) {
				setCookie('accessPermission', response.accessLevel, '');

				window.location.assign('dashboard.php');
			} else if (response.errorMessage) {
				createModal({
					'title': 'Não foi possível logar',
					'hideBtnCancel': true,
					'smallModal': true,
					'body': response.errorMessage
				});
			} else {
				createModal({
					'title': 'Não foi possível logar',
					'body': response.responseText
				});
			}
		}
	});

	ajax.POST('Service/Auth.php', {
		'userName': $('#userName').val(),
		'password': $('#password').val()
	});
}