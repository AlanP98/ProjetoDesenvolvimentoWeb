class Ajax {
	constructor(options) {
		this.options = (typeof options === "undefined" ? {} : options);

		this.async = (this.options.async || false);
		this.beforeSend = this.options.beforeSendFn;
		this.contentType = (this.options.contentType || 'application/x-www-form-urlencoded; charset=UTF-8');
		this.dataType = (this.options.dataType || 'html');
		this.fail = this.options.failFn;
		this.done = this.options.doneFn;
		this.always = this.options.alwaysFn;
	}

	GET(url, data) {
		return this.request('GET', url, data);
	}

	POST(url, data) {
		return this.request('POST', url, data);
	}

	PUT(url, data) {
		return this.request('PUT', url, data);
	}

	DELETE(url, data) {
		return this.request('DELETE', url, data);
	}

	request(method, url, data) {
		// var deferred = $.Deferred();
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
		}).fail(function (response) {
			// deferred.fail();

			if (typeof failFn === 'function') {
				failFn(response);
			}
		}).done(function (response) {
			// deferred.resolve();

			if (typeof doneFn === 'function') {
				doneFn(response);
			}
		}).always(function (response) {
			if (typeof alwaysFn === 'function') {
				alwaysFn(response);
			}
		});

		// return deferred.promise();
	}
}

function debug(o) {
	console.log(o);
}

function getFormData(form) {
	var formArray = form.serializeArray();
	var formData = {};

	$.map(formArray, function(key, val) {
		formData[key['name']] = key['value'];
	});

	return formData;
}

function toggleForm(element, toggleBtn, objName) {
	if (element.is(':visible')) {
		toggleBtn.text('Exibir ' + (objName || 'formulário'));
	} else {
		toggleBtn.text('Ocultar ' + (objName || 'formulário'));
	}

	element.slideToggle();
}

function createAlert(options) {
	scrollTop();

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

function createModal(options) {
	var modalId = (options.modalId || 'modal');
	var buttons = [];
	buttons[0] = {};
	buttons[1] = {};

	if (!options.hideBtnCancel) {
		buttons[0] = $('<button>', {
			'type': 'button',
			'class': 'btn btn-default',
			'data-dismiss': 'modal',
			'text': (options.textBtnCancel || 'Cancelar'),
			'id': options.idBtnCancel || 'modalBtnCancel',
			'click': function () {
				if (options.fnCancel) {
					options.fnCancel();
				} else {
					destroyModal(modalId);
				}
			}
		});
	}

	if (!options.hideBtnOk) {
		buttons[1] = $('<button>', {
			'type': 'button',
			'class': 'btn ' + (options.classBtnOk ? options.classBtnOk : 'btn-primary'),
			'text': (options.textBtnOk || 'OK'),
			'id': options.idBtnOk || 'modalBtnOk',
			'click': function () {
				if (options.fnOk) {
					options.fnOk();
				} else {
					destroyModal(modalId);
				}
			}
		});
	}

	var modalSize = (options.largeModal ? 'modal-lg' : (options.smallModal ? 'modal-sm' : ''));
	var modal = $('<div>', { 'id': modalId, 'class': 'modal fade', 'tabindex': '-1', 'role': 'dialog', 'aria-labelledby': 'modalLabel' }).append(
		$('<div>', { 'class': 'modal-dialog ' + modalSize, 'role': 'document' }).append(
			$('<div>', { 'class': 'modal-content' }).append(
				$('<div>', { 'class': 'modal-header' }).append(
					$('<h5>', { 'id': 'modalLabel' + modalId, 'class': 'modal-title', 'text': (options.title || 'Atenção') }),
					$('<button>', { 'type': 'button', 'class': 'close', 'data-dismiss': 'modal', 'aria-label': 'Close' }).append(
						$('<span>', { 'aria-hidden': 'true', 'html': '&times;' })
					)
				),
				$('<div>', { 'id': 'modalBody' + modalId, 'class': 'modal-body', 'html': '' }),
				$('<div>', { 'class': 'modal-footer' }).append(
					buttons[0],
					buttons[1]
				)
			)
		)
	);

	modal.modal({ backdrop: 'static'})
		.on('show.bs.modal', function () {
			if (options.fnBeforeOpen) {
				options.fnBeforeOpen();
			}
		})
		.on('shown.bs.modal', function () {
			$('#modalBody' + modalId).append($('<div>' + options.body + '</div>'));
			if (options.fnAfterOpen) {
				options.fnAfterOpen();
			}
		})
		.on('hide.bs.modal', function () {
			jQuery(this).remove();
			if (options.fnBeforeClose) {
				options.fnBeforeClose();
			}
		})
		.on('hidden.bs.modal', function () {
			jQuery(this).remove();
			if (options.fnAfterClose) {
				options.fnAfterClose();
			}
		});

	$('#' + modalId).modal('handleUpdate');
}

function destroyModal(id, options) {
	id = (id || 'modal');
	options = options || {};
	$('#' + id).modal('hide').data('bs.modal', null);

	if (options.fnAfterDestroy) {
		options.fnAfterDestroy();
	}
}

function getContentEmptySearch(obj) {
	if ($.isEmptyObject(obj)) {
		return $('<div>', {'class': 'alert alert-info mt-4', 'role': 'alert', 'html': 'Nenhum registro encontrado.'});
	} else {
		return false;
	}
}

function displayErrors(response) {
	if (response.errorMessage || response.responseText) {
		createModal({
			'modalId': 'modalErr',
			'hideBtnCancel': true,
			'title': 'Aviso',
			'body': (response.errorMessage || response.responseText)
		});

		return true;
	}

	return false;
}

function scrollTop() {
	$('html, body').animate({ scrollTop: 0 }, 500);
}

function initTooltips() {
	setTimeout(function () {
		$('[data-toggle="tooltip"]').tooltip();
		$('body').mouseup(function() {
			$('[data-toggle="tooltip"], .tooltip').tooltip("hide");
		});
	}, 500);
};