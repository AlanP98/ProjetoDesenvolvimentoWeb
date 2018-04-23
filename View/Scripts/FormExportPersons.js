$(function() {

	$('#btnExportPersons').click(function() {
		var formData = getFormData($('#formExportPerson'));

		var data = {'exporterType': formData.exportationType, 'object': 'Person'};
		var ajax = new Ajax({
			alwaysFn: function(response) {
				$('#result').html('<pre>' + response + '</pre>');
			}
		});

		ajax.GET('Service/RegisterExportation.php', data);
	});

});