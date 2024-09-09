var manageSupplierTable;

$(document).ready(function() {
	// active navSuppliers bar
	$("#navSuppliers").addClass('active');

	// manage supplier table
	manageSupplierTable = $("#manageSupplierTable").DataTable({
		'ajax' : 'php_action/fetchSuppliers.php',
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
});

function addSupplier() {
	// reset the form text
	$("#addSupplierForm")[0].reset();
	// remove error text
	$(".text-danger").remove();
	// remove the form error
	$(".form-group").removeClass('has-error').removeClass('has-success');

	// submit brand form function
	$("#addSupplierForm").unbind('submit').bind('submit', function(){

		// remove error text
		$(".text-danger").remove();
		// remove the form error
		$(".form-group").removeClass('has-error').removeClass('has-success');

		var supplierName = $("#supplierName").val();
		var supplierPerson = $("#supplierPerson").val();
		var supplierContact = $("#supplierContact").val();
		var supplierStatus = $("#supplierStatus").val();
		var supplierAddress = $("#supplierAddress").val();
		var supplierMail = $("#supplierMail").val();

		if (supplierName == "") {
			$("#supplierName").after('<p class="text-danger">Company Name field is required</p>');
			$("#supplierName").closest('.form-group').addClass('has-error');
		} else {
			// remove error text field
			$("#supplierName").find('.text-danger').remove();
			$("#supplierName").closest('.form-group').addClass('has-success');
		}

		if (supplierPerson == "") {
			$("#supplierPerson").after('<p class="text-danger">Contact Person field is required</p>');
			$("#supplierPerson").closest('.form-group').addClass('has-error');
		} else {
			// remove error text field
			$("#supplierPerson").find('.text-danger').remove();
			$("#supplierPerson").closest('.form-group').addClass('has-success');
		}

		if (supplierStatus == "") {
			$("#supplierStatus").after('<p class="text-danger">Status field is required</p>');
			$("#supplierStatus").closest('.form-group').addClass('has-error');
		} else {
			// remove error text field
			$("#supplierStatus").find('.text-danger').remove();
			$("#supplierStatus").closest('.form-group').addClass('has-success');
		}

		if (supplierAddress == "") {
			$("#supplierAddress").after('<p class="text-danger">Address field is required</p>');
			$("#supplierAddress").closest('.form-group').addClass('has-error');
		} else {
			// remove error text field
			$("#supplierAddress").find('.text-danger').remove();
			$("#supplierAddress").closest('.form-group').addClass('has-success');
		}

		if (supplierContact != "" && /^(\d{10}|\d{11}|\d{2}\-\d{4}\-\d{4}|\d{2}\-\d{8}|\d{3}\-\d{3}\-\d{4}|\d{3}\-\d{4}\-\d{4}|\d{3}\-\d{7}|\d{3}\-\d{8})$/.test(supplierContact)) {
			// remove error text field
			$("#supplierContact").find('.text-danger').remove();
			$("#supplierContact").closest('.form-group').addClass('has-success');
		} else if (supplierContact != "" && /^(\d{10}|\d{11}|\d{2}\-\d{4}\-\d{4}|\d{2}\-\d{8}|\d{3}\-\d{3}\-\d{4}|\d{3}\-\d{4}\-\d{4}|\d{3}\-\d{7}|\d{3}\-\d{8})$/.test(supplierContact) == false) {
			$("#supplierContact").after('<p class="text-danger">Contact field format is incorrect<br />Example:012-1234567</p>');
			$("#supplierContact").closest('.form-group').addClass('has-error');
		} else if (supplierContact == "") {
			$("#supplierContact").after('<p class="text-danger">Contact field is required</p>');
			$("#supplierContact").closest('.form-group').addClass('has-error');
		}

		if (supplierMail && /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(supplierMail)) {
			// remove error text field
			$("#supplierMail").find('.text-danger').remove();
			$("#supplierMail").closest('.form-group').addClass('has-success');
		} else if (supplierMail != "" && /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(supplierMail) == false) {
			$("#supplierMail").after('<p class="text-danger">E-mail field format is incorrect</p>');
			$("#supplierMail").closest('.form-group').addClass('has-error');
			return false;
		}

		if (supplierName && supplierPerson && supplierContact && supplierStatus && supplierAddress && /^(\d{10}|\d{11}|\d{2}\-\d{4}\-\d{4}|\d{2}\-\d{8}|\d{3}\-\d{3}\-\d{4}|\d{3}\-\d{4}\-\d{4}|\d{3}\-\d{7}|\d{3}\-\d{8})$/.test(supplierContact)) {
			var form = $(this);

			// button loading
			$("#createSupplierBtn").button('loading');

			$.ajax({
				url: form.attr('action'),
				type: form.attr('method'),
				data: form.serialize(),
				dataType: 'json',
				success:function(response) {
					// button loading
					$("#createSupplierBtn").button('reset');

					if (response.success == true) {
						// reload the manage member table
						manageSupplierTable.ajax.reload(null, false);

            $("html, body, div.modal, div.modal-content, div.modal-body").stop(true, true).animate({scrollTop: '0'}, 100);

						// reset the form text
						$("#addSupplierForm")[0].reset();
						// remove error text
						$(".text-danger").remove();
						// remove the form error
						$(".form-group").removeClass('has-error').removeClass('has-success');

						$('.add-supplier-messages').html('<div class="alert alert-success">' +
  					'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
  					'<strong><i class="glyphicon glyphicon-ok-sign"></i></strong>' + response.messages +
						'</div>');

						$(".alert-success").delay(500).show(10, function() {
							$(this).delay(3000).hide(10, function(){
								$(this).remove();
							});
						});// /.alert
					} else {
            $("html, body, div.modal, div.modal-content, div.modal-body").stop(true, true).animate({scrollTop: '0'}, 100);

            // remove error text
						$(".text-danger").remove();
						// remove the form error
						$(".form-group").removeClass('has-error').removeClass('has-success');
            
						$('.add-supplier-messages').html('<div class="alert alert-warning">' +
  					'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
  					'<strong><i class="glyphicon glyphicon-ok-sign"></i></strong>' + response.messages +
						'</div>');

						$(".alert-warning").delay(500).show(10, function() {
							$(this).delay(3000).hide(10, function(){
								$(this).remove();
							});
						});// /.alert
					}
				}// /success:function(response)
			});// /$.ajax
		}// /if

		return false;
	});// /submit addEventForm
}// /function addSupplier()

function editSupplier(supplierId = null) {
	if (supplierId) {
		// remove brandID
		$("#supplierId").remove();
		// refresh the form
		$("#editSupplierForm")[0].reset();
		// remove text
		$(".text-danger").remove();
		// remove form error
		$(".form-group").removeClass('has-error').removeClass('has-success');

		$(".editSupplierFooter").after('<input type="hidden" name="supplierId" id="supplierId" value="'+ supplierId +'" />');
		
		$.ajax({
			url: 'php_action/fetchSelectedSuppliers.php',
			type: 'post',
			data: {supplierId : supplierId},
			dataType: 'json',
			success:function(response) {
				$("#editSupplierName").val(response.supplier_name);
				$("#editSupplierPerson").val(response.contact_person);
				$("#editSupplierContact").val(response.supplier_contact);
				$("#editSupplierStatus").val(response.supplier_active);
				$("#editSupplierMail").val(response.supplier_email);
				$("#editSupplierAddress").val(response.supplier_address);

				// submit edit supplier form function
				$("#editSupplierForm").unbind('submit').bind('submit', function() {
					// remove the error text
					$(".text-danger").remove();
					// remove the form error
					$(".form-group").removeClass('has-error').removeClass('has-success');

					var supplierName = $("#editSupplierName").val();
					var supplierPerson = $("#editSupplierPerson").val();
					var supplierContact = $("#editSupplierContact").val();
					var supplierStatus = $("#editSupplierStatus").val();
					var supplierMail = $("#editSupplierMail").val();
					var supplierAddress = $("#editSupplierAddress").val();

					if (supplierName == "") {
						$("#editSupplierName").after('<p class="text-danger">Company Name field is required</p>');
						$("#editSupplierName").closest('.form-group').addClass('has-error');
					} else {
						// remove error text field
						$("#editSupplierName").find('.text-danger').remove();
						$("#editSupplierName").closest('.form-group').addClass('has-success');
					}

					if (supplierPerson == "") {
						$("#editSupplierPerson").after('<p class="text-danger">Contact Person field is required</p>');
						$("#editSupplierPerson").closest('.form-group').addClass('has-error');
					} else {
						// remove error text field
						$("#editSupplierPerson").find('.text-danger').remove();
						$("#editSupplierPerson").closest('.form-group').addClass('has-success');
					}

					if (supplierStatus == "") {
						$("#editSupplierStatus").after('<p class="text-danger">Status field is required</p>');
						$("#editSupplierStatus").closest('.form-group').addClass('has-error');
					} else {
						// remove error text field
						$("#editSupplierStatus").find('.text-danger').remove();
						$("#editSupplierStatus").closest('.form-group').addClass('has-success');
					}

					if (supplierContact && /^(\d{10}|\d{11}|\d{2}\-\d{4}\-\d{4}|\d{2}\-\d{8}|\d{3}\-\d{3}\-\d{4}|\d{3}\-\d{4}\-\d{4}|\d{3}\-\d{7}|\d{3}\-\d{8})$/.test(supplierContact)) {
						// remove error text field
						$("#editSupplierContact").find('.text-danger').remove();
						$("#editSupplierContact").closest('.form-group').addClass('has-success');
					} else if (supplierContact != "" && /^(\d{10}|\d{11}|\d{2}\-\d{4}\-\d{4}|\d{2}\-\d{8}|\d{3}\-\d{3}\-\d{4}|\d{3}\-\d{4}\-\d{4}|\d{3}\-\d{7}|\d{3}\-\d{8})$/.test(supplierContact) == false) {
						$("#editSupplierContact").after('<p class="text-danger">Contact field format is incorrect</p>');
						$("#editSupplierContact").closest('.form-group').addClass('has-error');
					} else if (supplierContact == "") {
						$("#editSupplierContact").after('<p class="text-danger">Contact field is required</p>');
						$("#editSupplierContact").closest('.form-group').addClass('has-error');
					}

					if (supplierMail && /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(supplierMail)) {
						// remove error text field
						$("#editSupplierMail").find('.text-danger').remove();
						$("#editSupplierMail").closest('.form-group').addClass('has-success');
					} else if (supplierMail != "" && /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(supplierMail) == false) {
						$("#editSupplierMail").after('<p class="text-danger">E-mail field format is incorrect</p>');
						$("#editSupplierMail").closest('.form-group').addClass('has-error');
						return false;
					}

					if(supplierName && supplierPerson && supplierContact && supplierStatus && supplierAddress && /^(\d{10}|\d{11}|\d{2}\-\d{4}\-\d{4}|\d{2}\-\d{8}|\d{3}\-\d{3}\-\d{4}|\d{3}\-\d{4}\-\d{4}|\d{3}\-\d{7}|\d{3}\-\d{8})$/.test(supplierContact)) {
						var form = $(this);

						$.ajax({
							url: form.attr('action'),
							type: form.attr('method'),
							data: form.serialize(),
							dataType: 'json',
							success:function(response) {
								if(response.success == true) {
									// reload the manage member table
									manageSupplierTable.ajax.reload(null, false);
									
			            $("html, body, div.modal, div.modal-content, div.modal-body").stop(true, true).animate({scrollTop: '0'}, 100);
									// remove error text
									$(".text-danger").remove();
									// remove the form error
									$(".form-group").removeClass('has-error').removeClass('has-success');

									$('.edit-supplier-messages').html('<div class="alert alert-success">' +
		  						'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
		  						'<strong><i class="glyphicon glyphicon-ok-sign"></i></strong>' + response.messages +
									'</div>');

									$(".alert-success").delay(500).show(10, function() {
										$(this).delay(3000).hide(10, function(){
											$(this).remove();
										});
									});// /.alert
								}// /if
							}
						});// /$.ajax
					}// /if()
				
					return false;
				});// /edit supplier form function
			}// /success
		});// /ajax
	}// /if(supplierId)
}// /function editSupplier()

function removeSupplier(supplierId = null) {
	if (supplierId) {
		$("#removeSupplierBtn").unbind('click').bind('click', function() {
			$.ajax({
				url: 'php_action/removeSuppliers.php',
				type: 'post',
				data: {supplierId : supplierId},
				dataType: 'json',
				success:function(response) {
					if (response.success == true) {
						// hide the modal
						$("#removeSupplierModal").modal('hide');

            $("html, body, div.modal, div.modal-content, div.modal-body").stop(true, true).animate({scrollTop: '0'}, 100);

						// reload the brand table
						manageSupplierTable.ajax.reload(null, false);

						$(".remove-messages").html('<div class="alert alert-success">' +
						'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
						'<strong><i class="glyphicon glyphicon-ok-sign"></i></strong>' + response.messages +
						'</div>');

						$(".alert-success").delay(500).show(10, function() {
							$(this).delay(3000).hide(10, function(){
								$(this).remove();
							});
						});// /.alert
					}
				}
			});// /$.ajax
		});
	}// /if(supplierId)
}// /function removeSupplier()