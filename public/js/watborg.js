
/**
 * Form Submit Function
 * --------------------------------------------
 */
function submitForm(form, add, reload = false){

	// Variables
	var url = $(form).attr("action");
	var formData = $(form).serializeArray();
	var loader = $(form);
	var select2 = $("[data-clear]");
	var target = $(".status");

	// Show loader
	loader.addClass("loading");

	// Submit data
	$.post(url, formData)
		.done(function (data) {
			target.html(data);
			//datatable.ajax.reload();

			// Only clear form if data is being added
			if(add === true){
				$(form)[0].reset();
				$(select2).val(null).trigger("change");
			}

			if(reload === true){
				//var datatable = $("#records").DataTable();
				//datatable.ajax.reload();
			}

		})
		.fail(function (jqXHR, textStatus, errorThrown) {
			target.html(jqXHR.responseText);
		})
		.always(function (data) {
			loader.removeClass("loading");
			$('html,body').animate({scrollTop: target.offset().top - 100}, 1000);
		});
}

/**
 * Datatable Ajax Delete Function
 * --------------------------------------------
 */
$('#records').on('mousedown mouseup','.delete-record', function(e) {
	$(this).bootstrap_confirm({
		message: 'Are you sure you want to delete',
		callback: function(event){

			var button = event.data.originalObject;
			var target = button.data("target");
			var loader = $("#table-loader");
			var datatable = $("#records").DataTable();

			// Show loader
			loader.addClass("loading");

			// Send data for deletion
			$.post(target)
				.done(function (data) {
                    $.notify({
                        type: 'success',
                        message: data
                    });
					datatable.ajax.reload();
					//console.log(data);
				})
				.fail(function (jqXHR, textStatus, errorThrown) {
                    $.notify({
                        type: 'danger',
                        message: jqXHR.responseText
                    });
					//console.log(jqXHR.responseText);
				})
				.always(function (data) {
					loader.removeClass("loading");
				});
		}
	});
	e.preventDefault();
});
