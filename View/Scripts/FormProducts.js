$(function() {

	list();

	$('#toggleForm').click(function() {
		toggleForm($('#registerProduct'), $('#toggleForm'));
	});

	$('#register').click(function() {
		add(getFormData($('#registerProduct')));
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

	ajax.GET('Lists/ProductList.php');
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
			} else {
				list();
			}

			if (errorMsg) {
				createAlert({
					'title': 'Aviso',
					'msg': errorMsg
				});
			}
		}
	});

	ajax.POST('Register/RegisterProduct.php', data);
}

function renderTable(products) {
	$('#listProductsContent').html('');
	$.each(products, function(i, product) {
		$('#listProductsContent').append(
			$('<tr>').append(
				$('<td>', {'html': product.recordNumber}),
				$('<td>', {'html': product.description})
			)
		);
	});
}