var manageEventTable;

$(document).ready(function() {
	manageEventTable = $("#manageEventTable").DataTable({
		'ajax' : 'php_action/fetchEventTable.php',
		'order' : [],
		"iDisplayLength": 8, // default size of entry show
		"bLengthChange": false, // disable user to select the size of entry
		// "paging" : false, // disable page changing
		"searching" : false, // desable search feature
		"info" : false, //disable number of entry shown
		// "ordering" : false //disable sorting feature
	});

	$('.content-container').addClass('body-loaded');

	$('.bottom-fixed').fadeOut('slow');

	$("#showHelpModal").on('hide.bs.modal', function() {
		$("#collapseW1").collapse('hide');
		$("#collapseW2").collapse('hide');
		$("#collapseH1").collapse('hide');
		$("#collapseH2").collapse('hide');
		$("#collapseH3").collapse('hide');
	});
});

function addEvent() {
	$("#addEventModal").on('hidden.bs.modal', function() {
		$("#dateStart").data("DateTimePicker").clear();
		$("#dateEnd").data("DateTimePicker").clear();
	});
	// reset the form text
	$("#createEventForm")[0].reset();
	// remove error text
	$(".text-danger").remove();
	// remove the form error
	$(".form-group").removeClass('has-error').removeClass('has-success');

	$('span.input-group-addon').bind('click', function() {
		$("div.modal, div.modal-content, div.modal-body").stop(true, false, true).animate({scrollTop: '1000'}, 1000);
	});

	$("#createEventForm").unbind('submit').bind('submit', function() {

		// remove error text
		$(".text-danger").remove();
		// remove the form error
		$(".form-group").removeClass('has-error').removeClass('has-success');

		var eventTitle = $("#eventTitle").val();
		var eventColor = $("#eventColor").val();
		var eventStart = $("#eventStart").val();
		var eventEnd =  $("#eventEnd").val();

		if(eventTitle == "") {
			$("#eventTitle").after('<p class="text-danger">Event Title field is required</p>');
			$("#eventTitle").closest('.form-group').addClass('has-error');
		} else {
			// remove error text field
			$("#eventTitle").find('.text-danger').remove();
			$("#eventTitle").closest('.form-group').addClass('has-success');
		}

		if(eventColor == "") {
			$("#eventColor").after('<p class="text-danger">Event Color field is required</p>');
			$("#eventColor").closest('.form-group').addClass('has-error');
		} else {
			// remove error text field
			$("#eventColor").find('.text-danger').remove();
			$("#eventColor").closest('.form-group').addClass('has-success');
		}

		if(eventStart == "") {
			$("#dateStart").after('<p class="text-danger">Start Date field is required</p>');
			$("#dateStart").closest('.form-group').addClass('has-error');
		} else {
			// remove error text field
			$("#dateStart").find('.text-danger').remove();
			$("#dateStart").closest('.form-group').addClass('has-success');
		}

		if(eventEnd == "") {
			$("#dateEnd").after('<p class="text-danger">End Date field is required</p>');
			$("#dateEnd").closest('.form-group').addClass('has-error');
		} else {
			// remove error text field
			$("#dateEnd").find('.text-danger').remove();
			$("#dateEnd").closest('.form-group').addClass('has-success');
		}
		
		if (eventTitle && eventColor && eventStart && eventEnd) {
			var form = $(this);

			$.ajax ({
				url: form.attr('action'),
				type: form.attr('method'),
				data: form.serialize(),
				dataType: 'json',
				success:function(response) {
					if (response.success == true) {
						// hide add event modal
						$("#addEventModal").modal('hide');

						// show success added event modal
						$("#updatedEventModal").modal('show');

						$("#updatedEventBtn").unbind('click').bind('click', function() {
							location.reload();
						});

						$("#updatedEventModal").on('hidden.bs.modal', function() {
							location.reload();
						});
					} else {
						$("#addEventModal").modal('hide');
						$("#failedUpdateEventModal").modal('show');
					}
				}// /success:function
			});// /$.ajax
		}

		return false;
	});// /submit add event form
}// /add event function

function editEvent(eventId = null) {
	if(eventId) {
		// hide the show modal
		$("#showEventModal").modal('hide');
		// remove error text
		$(".text-danger").remove();
		// remove the form error
		$(".form-group").removeClass('has-error').removeClass('has-success');

		$('span.input-group-addon').bind('click', function() {
			$("div.modal, div.modal-content, div.modal-body").stop(true, false, true).animate({scrollTop: '1000'}, 1000);
		});
	
		$("#editEventForm").unbind('submit').bind('submit', function() {
	
			// remove error text
			$(".text-danger").remove();
			// remove the form error
			$(".form-group").removeClass('has-error').removeClass('has-success');
	
			var eventTitle = $("#editEventTitle").val();
			var eventColor = $("#editEventColor").val();
			var eventStart = $("#editEventStart").val();
			var eventEnd =  $("#editEventEnd").val();
	
			if(eventTitle == "") {
					$("#editEventTitle").after('<p class="text-danger">Event Title field is required</p>');
					$("#editEventTitle").closest('.form-group').addClass('has-error');
				} else {
					// remove error text field
					$("#editEventTitle").find('.text-danger').remove();
					$("#editEventTitle").closest('.form-group').addClass('has-success');
				}
	
				if(eventColor == "") {
					$("#editEventColor").after('<p class="text-danger">Event Color field is required</p>');
					$("#editEventColor").closest('.form-group').addClass('has-error');
				} else {
					// remove error text field
					$("#editEventColor").find('.text-danger').remove();
					$("#editEventColor").closest('.form-group').addClass('has-success');
				}
	
				if(eventStart == "") {
					$("#editDateStart").after('<p class="text-danger">Start Date field is required</p>');
					$("#editDateStart").closest('.form-group').addClass('has-error');
				} else {
					// remove error text field
					$("#editDateStart").find('.text-danger').remove();
					$("#editDateStart").closest('.form-group').addClass('has-success');
				}
	
				if(eventEnd == "") {
					$("#editDateEnd").after('<p class="text-danger">End Date field is required</p>');
					$("#editDateEnd").closest('.form-group').addClass('has-error');
				} else {
					// remove error text field
					$("#editDateEnd").find('.text-danger').remove();
					$("#editDateEnd").closest('.form-group').addClass('has-success');
				}

				if(eventTitle && eventColor && eventStart && eventEnd) {
					var form = $(this);

					$.ajax({
						url: form.attr('action'),
						type: form.attr('method'),
						data: form.serialize(),
						dataType: 'json',
						success:function(response) {
							if(response.success == true) {
								manageEventTable.ajax.reload(null, false);
								// hide edit event modal
								$("#editEventModal").modal('hide');

								// show show event modal
								$("#updatedEventModal").modal('show');

								$("#updatedEventBtn").unbind('click').bind('click', function() {
									location.reload();
								});

								$("#updatedEventModal").on('hidden.bs.modal', function() {
									location.reload();
								});
							}  else {
								$("#failedUpdateEventModal").modal('show');
								$("#editEventModal").modal('hide');
							}
						}// /success:function
					});// /$.ajax
				}// /if

			return false;
		});// /submit edit event form
	}// / if
}// /edit event function

function removeEvent(eventId = null) {
	// hide show event modal
	$("#showEventModal").modal('hide');

	if(eventId) {
		// alert(eventId);
		$("#removeEventBtn").unbind('click').bind('click', function() {
			$.ajax({
				url: 'php_action/removeEvent.php',
				type: 'post',
				data: {eventId : eventId},
				dataType: 'json',
				success:function(response) {
					if (response.success == true) {
						// hide the remove modal
						$("#removeEventModal").modal('hide');
						// hide the show modal
						$("#showEventModal").modal('hide');

						// show show event modal
						$("#updatedEventModal").modal('show');

            $("html, body, div.modal, div.modal-content, div.modal-body").stop(true, true).animate({scrollTop: '0'}, 100);

            $("#calendar").fullCalendar('removeEvents', eventId);

            $("#calendar").fullCalendar('changeView', 'month');

            manageEventTable.ajax.reload(null, false);
					} else {
						$("#removeEventModal").modal('hide');
						$("#failedUpdateEventModal").modal('show');
					}
				}// /success:function
			});// /$.ajax
		});// /click removeEventBtn
	}// /if eventId = true
}// /removeEvent function