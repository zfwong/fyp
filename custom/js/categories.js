var manageCategoriesTable;

$(document).ready(function() {
	// top navBrCa bar active
	$("#navBrCa").addClass('active');
	// active top navbar category
	$("#navCategories").addClass('active');
	// manage categories datatable
	manageCategoriesTable = $("#manageCategoriesTable").DataTable({
		'ajax' : 'php_action/fetchCategories.php',
		'order' : []
	});

	$("#showHelpModal").on('hide.bs.modal', function() {
		$("#collapseH1").collapse('hide');
		$("#collapseH2").collapse('hide');
		$("#collapseH3").collapse('hide');
	});

	/*smooth toggle dropdown*/
  $('.dropdown').on('show.bs.dropdown', function () {
  	$(this).find('.dropdown-menu').first().stop(true, true).slideDown(100);
	});

	$('.dropdown').on('hide.bs.dropdown', function () {
  	$(this).find('.dropdown-menu').first().stop(true, true).slideUp(100);
	});
	
	$('.content-container').addClass('body-loaded');
	
	$('.bottom-fixed').fadeOut('slow');

	// on click on submit categories form modal
	$("#addCategoriesModalBtn").unbind('click').bind('click', function() {
		// reset the form text
		$("#submitCategoriesForm")[0].reset();
		// remove the error text
		$('.text-danger').remove();
		// remove the form error
		$('.form-group').removeClass('has-error').removeClass('has-success');

		$("#submitCategoriesForm").unbind('submit').bind('submit', function() {

			// remove the error text
			$('.text-danger').remove();
			// remove the form error
			$('.form-group').removeClass('has-error').removeClass('has-success');

			// alert('OK');
			var categoriesName = $("#categoriesName").val();
			var categoriesStatus = $("#categoriesStatus").val();

			if (categoriesName == "") {
				$("#categoriesName").after("<p class='text-danger'>Categories Name Field is required</p>");
				$("#categoriesName").closest('.form-group').addClass('has-error');
			} else {
				// remove error text Field
				$("#categoriesName").find('.text-danger').remove();
				// success out for form
				$("#categoriesName").closest('.form-group').addClass('has-success');
			}

			if (categoriesStatus == "") {
				$("#categoriesStatus").after("<p class='text-danger'>Categories Status Field is required</p>");
				$("#categoriesStatus").closest('.form-group').addClass('has-error');
			} else {
				// remove error text Field
				$("#categoriesStatus").find('.text-danger').remove();
				// success out for form
				$("#categoriesStatus").closest('.form-group').addClass('has-success');
			}

			if (categoriesName && categoriesStatus) {
				var form = $(this);

				$.ajax({
					url: form.attr('action'),
					type: form.attr('method'),
					data: form.serialize(),
					dataType: 'json',
					success:function(response) {
						if (response.success == true) {
							// reload the manage member datatable
							manageCategoriesTable.ajax.reload(null, false);

							// reset the form text
							$("#submitCategoriesForm")[0].reset();
							// remove the error text
							$('.text-danger').remove();
							// remove the form error
							$('.form-group').removeClass('has-error').removeClass('has-success');

							$("#add-categories-messages").html('<div class="alert alert-success">' +
		  						'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
		  						'<strong><i class="glyphicon glyphicon-ok-sign"></i></strong>' + response.messages +
									'</div>');

							$(".alert-success").delay(500).show(10, function() {
								$(this).delay(3000).hide(10, function(){
									$(this).remove();
								});
							});// /.alert
						} else {
							// remove the error text
							$('.text-danger').remove();
							// remove the form error
							$('.form-group').removeClass('has-error').removeClass('has-success');

							$("#add-categories-messages").html('<div class="alert alert-warning">' +
		  						'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
		  						'<strong><i class="glyphicon glyphicon-ok-sign"></i></strong>' + response.messages +
									'</div>');

							$(".alert-warning").delay(500).show(10, function() {
								$(this).delay(3000).hide(10, function(){
									$(this).remove();
								});
							});// /.alert
						}
					}// /success
				});// /ajax
			}// /if

			return false;
		});// /submit categories form function
	});// /on click on submit categories form modal
});// / document

// update categories function
function editCategories(categoriesId = null) {
	if (categoriesId) {

		// remove the categories id
		$("#editCategoriesId").remove();
		// reset the form text
		$("#editCategoriesForm")[0].reset();
		// reset the form text error
		$('.text-danger').remove();
		// reset the form group error
		$('.form-group').removeClass('has-error').removeClass('has-success');

		// edit categories messages remove
		$("#edit-categories-messages").html('');

		$.ajax({
			url: 'php_action/fetchSelectedCategories.php',
			type: 'post',
			data: {categoriesId : categoriesId},
			dataType: 'json',
			success:function(response) {
				$("#editcategoriesName").val(response.categories_name);
				$("#editcategoriesStatus").val(response.categories_active);

				// add categories id
				$(".editCategoriesFooter").after('<input type="hidden" name="editCategoriesId" id="editCategoriesId" value="'+response.categories_id+'" />');

				// submit of edit categories form
				$("#editCategoriesForm").unbind('submit').bind('submit', function() {

					// remove the error text
					$('.text-danger').remove();
					// remove the form error
					$('.form-group').removeClass('has-error').removeClass('has-success');

					// alert('OK');
					var categoriesName = $("#editcategoriesName").val();
					var categoriesStatus = $("#editcategoriesStatus").val();

					if (categoriesName == "") {
						$("#editcategoriesName").after("<p class='text-danger'>Categories Name Field is required</p>");
						$("#editcategoriesName").closest('.form-group').addClass('has-error');
					} else {
						// remove error text Field
						$("#editcategoriesName").find('.text-danger').remove();
						// success out for form
						$("#editcategoriesName").closest('.form-group').addClass('has-success');
					}

					if (categoriesStatus == "") {
						$("#editcategoriesStatus").after("<p class='text-danger'>Categories Status Field is required</p>");
						$("#editcategoriesStatus").closest('.form-group').addClass('has-error');
					} else {
						// remove error text Field
						$("#editcategoriesStatus").find('.text-danger').remove();
						// success out for form
						$("#editcategoriesStatus").closest('.form-group').addClass('has-success');
					}

					if (categoriesName && categoriesStatus) {
						var form = $(this);

						$.ajax({
							url: form.attr('action'),
							type: form.attr('method'),
							data: form.serialize(),
							dataType: 'json',
							success:function(response) {
								if (response.success == true) {
									// reload the manage member datatable
									manageCategoriesTable.ajax.reload(null, false);
									// remove the error text
									$('.text-danger').remove();
									// remove the form error
									$('.form-group').removeClass('has-error').removeClass('has-success');

									$("#edit-categories-messages").html('<div class="alert alert-success">' +
		  						'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
		  						'<strong><i class="glyphicon glyphicon-ok-sign"></i></strong>' + response.messages +
									'</div>');

									$(".alert-success").delay(500).show(10, function() {
										$(this).delay(3000).hide(10, function(){
											$(this).remove();
										});
									});// /.alert
								} else {
									// remove the error text
									$('.text-danger').remove();
									// remove the form error
									$('.form-group').removeClass('has-error').removeClass('has-success');
									
									$("#edit-categories-messages").html('<div class="alert alert-warning">' +
		  						'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
		  						'<strong><i class="glyphicon glyphicon-ok-sign"></i></strong>' + response.messages +
									'</div>');

									$(".alert-warning").delay(500).show(10, function() {
										$(this).delay(3000).hide(10, function(){
											$(this).remove();
										});
									});// /.alert
								}
							}// /success
						});// /ajax
					}// /if

					return false;
				});// /submit categories form function

			}// /success
		});// /$.ajax
	}// /if
}// /update categories function


// remove categories function
function removeCategories(categoriesId = null) {
	if (categoriesId) {
		// alert('ok');
		// remove categories button click to remove
		$("#removeCategoriesBtn").unbind('click').bind('click', function() {
			// alert(categoriesId);
			$.ajax({
				url: 'php_action/removeCategories.php',
				type: 'post',
				data: {categoriesId : categoriesId},
				dataType: 'json',
				success:function(response) {
					if (response.success == true) {
						// close the modal
						$("#removeCategoriesModal").modal('hide');
						// update the manage categories table
						manageCategoriesTable.ajax.reload(null, false);
						// show the message
						$('.remove-messages').html('<div class="alert alert-success">' +
						'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
						'<strong><i class="glyphicon glyphicon-ok-sign"></i></strong>' + response.messages +
						'</div>');

						$(".alert-success").delay(500).show(10, function() {
							$(this).delay(3000).hide(10, function(){
								$(this).remove();
							});
						});// /.alert

					} else {
						// close the modal
						$("#removeCategoriesModal").modal('hide');
						// show the message
						$('.remove-messages').html('<div class="alert alert-warning">' +
						'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
						'<strong><i class="glyphicon glyphicon-exclamation-sign"></i></strong>' + response.messages +
						'</div>');

						$(".alert-warning").delay(500).show(10, function() {
							$(this).delay(3000).hide(10, function(){
								$(this).remove();
							});
						});// /.alert
					}
				}
			});
		});
	}// /if categories id
}// /remove categories function