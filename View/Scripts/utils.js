function getFormData(form) {
	var formArray = form.serializeArray();
	var formData = {};

	$.map(formArray, function(key, val) {
		formData[key['name']] = key['value'];
	});

	return formData;
}

function toggleForm(element, toggleBtn) {
	if (element.is(':visible')) {
		toggleBtn.text('Abrir formulário');
	} else {
		toggleBtn.text('Fechar formulário');
	}

	element.slideToggle();
}

function createAlert(options) {
	$('#infos').append(
		$('<div>', {'class': 'alert alert-' + (options.alertType || 'warning') + ' alert-dismissible fade show', 'role': 'alert'}).append(
			$('<strong>', {'html': options.title + '<br>'}),
			$('<span>', {'html': options.msg}),
			$('<button>', {'type': 'button', 'class': 'close', 'data-dismiss': 'alert', 'aria-label': 'Close'}).append(
				$('<span>', {'aria-hidden': true, 'html': '&times;'})
			)
		)
	);

	setTimeout(function() {
		$('#infos div:first').alert('close');
	}, (options.timeOut || 5000));
}

function getEndpoint(objectType, action) {
	var url = '';

	switch(action) {
		case 'cadastro':
			url += 'Register/Register';
			break;
		case 'exportação':
			url += 'Export/Export';
			break;
	}

	switch(objectType) {
		case 'produtos':
			url += 'Product.php';
			break;
		case 'clientes':
			url += 'Person.php';
			break;
	}

	return url;
}

class Ajax {
	constructor(options) {
		this.options = (options || {});

		this.async = (options.async || false);
		this.beforeSend = options.beforeSendFn;
		this.contentType = (options.contentType || 'application/x-www-form-urlencoded; charset=UTF-8');
		this.dataType = (options.dataType || 'html');
		this.fail = options.failFn;
		this.done = options.doneFn;
		this.always = options.alwaysFn;
	}

	GET(url, data) {
		this.request('GET', url, data);
	}

	POST(url, data) {
		this.request('POST', url, data);
	}

	PUT(url, data) {
		this.request('PUT', url, data);
	}

	DELETE(url, data) {
		this.request('DELETE', url, data);
	}

	request(method, url, data) {
		var doneFn = this.done;
		var failFn = this.fail;
		var alwaysFn = this.always;

		$.ajax({
			method: method,
			url: url,
			data: data,

			dataType: this.dataType,
			async: this.async,
			contentType: this.contentType,
			headers: this.headers,
			beforeSend: this.beforeSend,
		}).fail(function(response) {
			if(typeof failFn === 'function') {
				failFn(response);
			}
		}).done(function(response) {
			if(typeof doneFn === 'function') {
				doneFn(response);
			}
		}).always(function(response) {

			if(typeof alwaysFn === 'function') {
				alwaysFn(response);
			}
		});
	}
}