
/**
 * Form Submit Function
 * --------------------------------------------
 */
function submitForm(form, add = true, reload = false){

	// Variables
	var url = $(form).attr("action"),
		formData = $(form).serializeArray(),
		loader = $(form),select2 = $("[data-clear]"),
		target = $(".status");

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

	// Prevent default action
	event.preventDefault();
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


/**
 * Formart Date Function
 * --------------------------------------------
 * E.g. 14/02/2019 to 02/14/2019 for support in Date() function
 */
function format_date(date_string, separator) {
	var dateParts = date_string.split(separator);
	formattedDate = dateParts[1] + '/' + dateParts[0] + '/' + dateParts[2];
	return new Date(formattedDate);
}