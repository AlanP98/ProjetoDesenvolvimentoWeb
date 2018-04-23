$(function() {
	list();

	$('#toggleForm').click(function() {
		toggleForm($('#formRegisterProduct'), $('#toggleForm'));
	});

	$('#register').click(function() {
		add(getFormData($('#formRegisterProduct')));
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

	ajax.GET('Service/ListProducts.php');
}

function add(data) {
	var ajax = new Ajax({
		dataType: 'json',
		alwaysFn: function(response) {
			displayErrors(response);
			list();
		}
	});

	ajax.POST('Service/RegisterProduct.php', data);
}

function deleteProducts(ids) {
	if (!confirm('Deseja deletar o produto?')) {
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
					'msg': 'Produto excluído!'
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
					$('<i>', { 'class': 'fas fa-trash-alt', 'color': '#ff4949ba', 'cursor': 'pointer', 'onClick': 'deleteProducts(' + product.id + ')' })
				)
			)
		);
	});
}