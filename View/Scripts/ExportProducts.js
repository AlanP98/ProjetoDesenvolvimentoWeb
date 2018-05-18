$(function () {

	$('#btnExportProducts').click(function () {
		var formData = getFormData($('#formExportProduct'));

		var data = { 'exporterType': formData.exportationType, 'object': 'Product' };
		var ajax = new Ajax({
			alwaysFn: function (response) {
				$('#result').html('<pre>' + response + '</pre>');
			}
		});

		ajax.GET('Service/RegisterExportation.php', data);
	});

});