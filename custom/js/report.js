$(document).ready(function() {
	$("#navReport").addClass('active');
	$('.content-container').addClass('body-loaded');
	
	$('.bottom-fixed').fadeOut('slow');

	$("#reportStart").datetimepicker({
		useCurrent: false,
		showClear: true,
		format: 'DD-MM-YYYY',
		widgetPositioning: {
			horizontal: 'left',
			vertical: 'bottom',
		},
	});

	$("#reportEnd").datetimepicker({
		useCurrent: false,
		showClear: true,
		format: 'DD-MM-YYYY',
		widgetPositioning: {
			horizontal: 'left',
			vertical: 'bottom',
		},
	});

	$("#reportStart").on("dp.change", function (e) {
    $("#reportEnd").data("DateTimePicker").minDate(e.date);
  });
  $("#reportEnd").on("dp.change", function (e) {
    $("#reportStart").data("DateTimePicker").maxDate(e.date);
  });

	/*smooth toggle dropdown*/
  $('.dropdown').on('show.bs.dropdown', function () {
  	$(this).find('.dropdown-menu').first().stop(true, true).slideDown(100);
	});

	$('.dropdown').on('hide.bs.dropdown', function () {
  	$(this).find('.dropdown-menu').first().stop(true, true).slideUp(100);
	});

	$("#getOrderReportForm").unbind('submit').bind('submit', function() {
		$('.form-group').removeClass('has-error');
		$('.text-danger').remove();

		var startDate = $("#reportStart").val();
		var endDate = $("#reportEnd").val();

		if (startDate == "") {
			$("#reportStart").after('<p class="text-danger">Start Date field is required</p>');
			$("#reportStart").closest('.form-group').addClass('has-error');
		} else {
			$("#reportStart").find('.text-danger').remove();
		}

		if (endDate == "") {
			$("#reportEnd").after('<p class="text-danger">End Date field is required</p>');
			$("#reportEnd").closest('.form-group').addClass('has-error');
		} else {
			$("#reportEnd").find('.text-danger').remove();
		}

		if (startDate && endDate) {
			var form = $(this);

			$.ajax({
				url: form.attr('action'),
				type: form.attr('method'),
				data: form.serialize(),
				dataType: 'text',
				success:function(response) {
					var mywindow = window.open('', 'Inventory Management System', 'height=400,width=600');
					mywindow.document.write('<html><head><title>Order Report Slip</title>');
					mywindow.document.write('</head><body>');
					mywindow.document.write(response);
					mywindow.document.write('</body></html>');

					mywindow.document.close();
					mywindow.focus();

					mywindow.print();
					mywindow.close();
				}
			});
		}

		return false;
	});
});

function resetOrderReport() {
	$(".text-danger").remove();
	$(".form-group").removeClass('has-error');
	$("#reportStart").data('DateTimePicker').clear();
	$("#reportEnd").date('DateTimePicker').clear();
}