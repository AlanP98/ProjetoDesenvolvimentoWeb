$(function() {
	list();

	$('#toggleFilters').click(function () {
		toggleForm($('#filters'), $('#toggleFilters'), 'filtros');
	});

	$('#registerProduct').click(function () {
		openRegisterForm();
	});

	$('#search').click(function () {
		list();
	});

	$('#clearFilters').click(function () {
		$('#filters input').val('');
		list();
	});

});

function list() {
	var data = {
		'recordNumber': $('#filterRecordNumber').val(),
		'description': $('#filterDescription').val()
	};

	var ajax = new Ajax({
		dataType: 'json',
		alwaysFn: function(response) {
			if (!displayErrors(response)) {
				renderTable(response);
			}
		}
	});

	ajax.GET('Service/ListProducts.php', data);
}


function save(data) {
	var ajax = new Ajax({
		dataType: 'json',
		alwaysFn: function (response) {
			list();

			if (!displayErrors(response)) {
				destroyModal('modalRegisterProduct');
				createAlert({
					'alertType': 'success',
					'title': 'Sucesso',
					'msg': 'Produto ' + (data.personId > 0 ? 'atualizado' : 'adicionado')
				});
			}
		}
	});

	ajax.POST('Service/RegisterProduct.php', data);
}

function deleteProducts(ids) {
	if (!confirm('Deseja excluir o produto?')) {
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
					'msg': 'Produto excluído!'
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

	ajax.DELETE('Service/DeleteProduct.php', data);
}

function renderTable(products) {
	$('#listProductsContent').html('');

	var content = getContentEmptySearch(products);
	if (content) {
		$('#listProducts').hide();
		$('#resultSearch').html(content);
		return false;
	} else {
		$('#listProducts').show();
		$('#resultSearch').html('');
	}

	$.each(products, function(i, product) {
		$('#listProductsContent').append(
			$('<tr>').append(
				$('<td>', {'html': product.recordNumber}),
				$('<td>', {'html': product.description}),
				$('<td>').append(
					$('<i>', { 'class': 'far fa-edit', 'color': 'green', 'cursor': 'pointer', 'data-toggle': 'tooltip', 'data-placement': 'top', 'title': 'Editar produto', 'onClick': 'updateForm(' + product.id + ')' }),
					$('<i>', { 'class': 'ml-3 far fa-trash-alt', 'color': '#ff4949ba', 'cursor': 'pointer', 'data-toggle': 'tooltip', 'data-placement': 'top', 'title': 'Excluir produto', 'onClick': 'deleteProducts(' + product.id + ')' })
				)
			)
		);
	});

	initTooltips();
}

function openRegisterForm(productId) {
	var ajax = new Ajax({
		alwaysFn: function (response) {
			createModal({
				'modalId': 'modalRegisterProduct',
				'title': (productId ? 'Atualizar' : 'Cadastrar') + ' produto',
				'body': response,
				'largeModal': true,
				'textBtnOk': (productId ? 'Atualizar' : 'Salvar'),
				'classBtnOk': (productId ? 'btn-primary' : 'btn-success'),
				'fnOk': function () {
					save(getFormData($('#formRegisterProduct')));
				},
				'fnAfterOpen': function () {
					initTooltips();
					if (productId) {
						$('#generateRecordNumber').attr('disabled', true);
					}
				}
			});
		}
	});

	ajax.GET('View/Forms/FormRegisterProduct.php');
}

function updateForm(productId) {
	var data = { 'id': productId };
	var ajax = new Ajax({
		'dataType': 'json',
		'beforeSendFn': function () {
			openRegisterForm(productId);
		},
		'alwaysFn': function (response) {
			if (! displayErrors(response)) {
				populateForm(response);
			}
		}
	});

	ajax.GET('Service/ListProducts.php', data);
}

function populateForm(product) {
	setTimeout(function () {
		$('#recordNumber').attr('readonly', true);
		$('#productId').val(product.id);
		$('#recordNumber').val(product.recordNumber);
		$('#description').val(product.description);
	}, 500);
}

function setRandomRecordNumber() {
	$('#recordNumber').val(generateRecordNumber());
}

function generateRecordNumber() {
	var numbers = [];
	var sum = 0;
	var checker = 9;
	var i = 0;

	while (i < 5) {
		var num = Math.floor(Math.random() * 10);
		numbers[i] = num;
		sum += num;
		i++;
	}

	checker = sum % 9;
	checker = (checker || 9);
	numbers[5] = checker;

	return numbers.join('');
}