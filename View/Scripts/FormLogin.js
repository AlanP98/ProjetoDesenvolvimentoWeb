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

	var data = {
		'userName': $('#userName').val(),
		'password': $('#password').val()
	};

	ajax.POST('Service/Auth.php', data);
}