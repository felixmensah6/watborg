
/**
 * Form Submit Function
 * --------------------------------------------
 */
function submitForm(form, add = true, reload = false){

	// Variables
	var url = $(form).attr("action"),
		formData = $(form).serializeArray(),
		loader = $(form),
        select2 = $("[data-clear]"),
		target = $(".status");

	// Show loader
	loader.addClass("loading");

	// Submit data
	$.post(url, formData)
		.done(function (data) {
            // Show success message
            target.html(data);

			// Only clear form if data is being added
			if(add === true){
				$(form)[0].reset();
				$(select2).val(null).trigger("change");
			}

            // Reload datatable if true
			if(reload === true){
				var datatable = $("#records").DataTable();
				datatable.ajax.reload();
			}
		})
		.fail(function (jqXHR, textStatus, errorThrown) {

            // Show error message
			target.html(jqXHR.responseText);

		})
		.always(function (data) {
			loader.removeClass("loading");
			$('html,body').animate({scrollTop: target.offset().top - 100}, 1000);
		});

	// Prevent default action
	return false;
}

/**
 * Reset Form Function
 * --------------------------------------------
 */
function resetForm(form, callback = null){

    // Variables
	var select2 = $("[data-clear]");

    // Reset
    $(form)[0].reset();
    $(select2).val(null).trigger("change");

    // Check if it is a function then call
    if(typeof callback == 'function'){
        callback();
    }

    // Prevent default action
	return false;
}

/**
 * Register Patient Function
 * --------------------------------------------
 */
function registerPatient(form, add = true, reload = false, alert = false){

	// Variables
	var url = $(form).attr("action"),
		formData = $(form).serializeArray(),
		loader = $(form),
        select2 = $("[data-clear]"),
		target = $(".status");

	// Show loader
	loader.addClass("loading");

	// Submit data
	$.post(url, formData)
		.done(function (data) {
            // Show success message
            if(alert === true){
                bootbox.alert(data);
            }else{
                target.html(data);
            }

			// Only clear form if data is being added
			if(add === true){
				$(form)[0].reset();
				$(select2).val(null).trigger("change");
                $(".selected-service").remove();
                $("#age").text('0');
                updateTotal();
			}

            // Reload datatable if true
			if(reload === true){
				var datatable = $("#records").DataTable();
				datatable.ajax.reload();
			}
		})
		.fail(function (jqXHR, textStatus, errorThrown) {

            // Show error message
			target.html(jqXHR.responseText);

		})
		.always(function (data) {
			loader.removeClass("loading");
			$('html,body').animate({scrollTop: target.offset().top - 100}, 1000);
		});

	// Prevent default action
	return false;
}

/**
 * Search and Fill Form with Patient Details
 * --------------------------------------------
 */
function searchPatient(button, url, inputID){

	// Variables
	var search = $(inputID).val(),
        form = $('#register-patient'),
        json = null,
        $this = $(button);

    // Check for a value before searching
    if(search != '' && search.length >= 4) {

    	// Show loader
    	$this.addClass("loading loading-inverse disabled");

    	// Submit data
    	$.post(url, {query: search})
    		.done(function (data) {
                json = JSON.parse(data);
                form.populate(json);
                $("#age").text(json['age']);
    		})
    		.fail(function (jqXHR, textStatus, errorThrown) {
                // Show alert
                bootbox.confirm({
                    message: jqXHR.responseText,
                    buttons: {
                        confirm: {
                            label: 'Yes'
                        }
                    },
                    callback: function (result) {
                        // Clear input if cancel is clicked
                        if(result == false) {
                            $(inputID).val('');
                        }
                    }
                });
    		})
    		.always(function (data) {
    			$this.removeClass("loading loading-inverse disabled");
    		});
    }

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

/**
 * Update Total/Sum Table Column Function
 * --------------------------------------------
 */
function updateTotal(){
    var sum = 0;
    // iterate through each td based on class and add the values
    $(".price").each(function() {

        var value = $(this).text(),
            value = value.replace(',' , '');
        // add only if the value is number
        if(!isNaN(value) && value.length != 0) {
            sum += parseFloat(value);
        }

        $('#total-cost').number(sum, 2);
    });
}

/**
 * Help/Support Modal
 * --------------------------------------------
 */
$('.help-modal').on('click', function(){
	var dataURL = $(this).attr('data-href');
	$('.modal-title').html('Help');
	$('.modal-body').load(dataURL, function(){
		$('#support-modal').modal({show: true});
	});
});


/**
 * Page Modal
 * --------------------------------------------
 */
$('.load-modal').on('click', function(){
	var dataURL = $(this).attr('data-url'),
		dataTitle = $(this).attr('data-title');
	$('.modal-title').html(dataTitle);
	$('.modal-body').load(dataURL, function(){
		$('#page-modal').modal({show: true});
	});
});

$('#records').on('click','.load-modal', function(e) {
	var dataURL = $(this).attr('data-url'),
		dataTitle = $(this).attr('data-title');
	$('.modal-title').html(dataTitle);
	$('.modal-body').load(dataURL, function(){
	 	$('#page-modal').modal({show: true});
	});
});

/**
 * Initialize Datatables
 * --------------------------------------------
 */
var this_table = $('#records'),
    data_ajax = $(this_table).attr('data-ajax'),
    data_save_state = $(this_table).attr('data-save-state'),
    data_targets = $(this_table).attr('data-targets'),
    data_targets = (data_targets != null) ? data_targets : '[]';
    data_targets = JSON.parse(data_targets);

$(this_table).DataTable({
    "processing": true,
    "stateSave": data_save_state,
    "serverSide": true,
    "ajax": data_ajax,
    "columnDefs": [
        {
            "searchable": false,
            "targets": data_targets
        }
    ]
});

/**
 * Global Initializations
 * --------------------------------------------
 */
(function() {

  "use strict";

    // Select2
    $('.select2').select2();

    // Datepicker
    $('.datetimepicker').datetimepicker();

})();
