$(document).ready(function() {

	$('.content-container').addClass('body-loaded');
	
	$('.bottom-fixed').fadeOut('slow');

	/*	avoid keyboard enter button to submit form*/	
	$(window).keydown(function(event){
    if(event.keyCode == 13) {
      event.preventDefault();
      return false;
    }
  });

  /*smooth toggle dropdown*/
  $('.dropdown').on('show.bs.dropdown', function () {
  	$(this).find('.dropdown-menu').first().stop(true, true).slideDown(100);
	});

	$('.dropdown').on('hide.bs.dropdown', function () {
  	$(this).find('.dropdown-menu').first().stop(true, true).slideUp(100);
	});

	// active nav User
	$("#navUser").addClass('active');
	// active top navSetting bar
	$("#topNavSetting").addClass('active');

	$("#changeUsernameForm").unbind('submit').bind('submit', function() {

		// remove error text field
		$('.text-danger').remove();
		// remove form-group error
		$('.form-group').removeClass('has-error').removeClass('has-success');

		var form = $(this);
		var username = $("#settingUsername").val();

		if (username == "") {
			$("#settingUsername").after("<p class='text-danger'>Username field is required</p>");
			$("#settingUsername").closest('.form-group').addClass('has-error');
		} else {
			// remove error text
			$("#settingUsername").find('.text-danger').remove();
			// remove error field
			$("#settingUsername").closest('.form-group').addClass('has-success');
			// button loading
			$("#changeUsernameBtn").button('loading');
			
			$.ajax({
				url: form.attr('action'),
				type: form.attr('method'),
				data: form.serialize(),
				dataType: 'json',
				success:function(response) {
					// scroll top
          $("html, body, div.modal, div.modal-content, div.modal-body").animate({scrollTop: '0'}, 100);

					// remove button loading
					$("#changeUsernameBtn").button('reset');
					// remove error text
					$('.text-danger').remove();
					// remove error field
					$('.form-group').removeClass('has-error').removeClass('has-success');

					if (response.success == true) {
						$("#changeUsernameMessage").html('<div class="alert alert-success alert-dismissible" role="alert">' + 
					  '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' + 
					  '<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> ' + response.messages + 
						'</div>');

						// remove the mesages
	          $(".alert-success").delay(500).show(10, function() {
							$(this).delay(3000).hide(10, function() {
								$(this).remove();
							});
						}); // /.alert

					} else {
						$("#changeUsernameMessage").html('<div class="alert alert-warning alert-dismissible" role="alert">' + 
					  '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' + 
					  '<strong><i class="glyphicon glyphicon-exclamation-sign"></i></strong> ' + response.messages + 
						'</div>');

						// remove the mesages
	          $(".alert-warning").delay(500).show(10, function() {
							$(this).delay(3000).hide(10, function() {
								$(this).remove();
							});
						}); // /.alert

					}
				}// /success:function
			});// /$.ajax
		}// /else

		return false;
	});// /change user name form

	$("#changePasswordForm").unbind('submit').bind('submit', function() {

		// remove error text field
		$('.text-danger').remove();
		// remove form-group error
		$('.form-group').removeClass('has-error').removeClass('has-success');

		var form = $(this);

		var currentPassword = $("#currentPassword").val();
		var newPassword = $("#newPassword").val();
		var confirmPassword = $("#confirmPassword").val();

		if (currentPassword == "" || newPassword == "" || confirmPassword == "") {
			if (currentPassword == "") {
				$("#currentPassword").after('<p class="text-danger">Current Password field is required</p>');
				$("#currentPassword").closest('.form-group').addClass('has-error');
			} else {
				// remove error text
				$("#currentPassword").find('.text-danger').remove();
				// remove error field
				$("#currentPassword").closest('.form-group').addClass('has-success');
			}

			if (newPassword == "") {
				$("#newPassword").after('<p class="text-danger">New Password field is required</p>');
				$("#newPassword").closest('.form-group').addClass('has-error');
			} else {
				// remove error text
				$("#newPassword").find('.text-danger').remove();
				// remove error field
				$("#newPassword").closest('.form-group').addClass('has-success');
			}

			if (confirmPassword == "") {
				$("#confirmPassword").after('<p class="text-danger">Confirm Password field is required</p>');
				$("#confirmPassword").closest('.form-group').addClass('has-error');
			} else {
				// remove error text
				$("#confirmPassword").find('.text-danger').remove();
				// remove error field
				$("#confirmPassword").closest('.form-group').addClass('has-success');
			}
		} else {
			$.ajax({
				url: form.attr('action'),
				type: form.attr('method'),
				data: form.serialize(),
				dataType: 'json',
				success:function(response) {
					// close the product modal
          $("#confirmChangesModal").modal('hide');
					// scroll top
          $("html, body, div.modal, div.modal-content, div.modal-body").animate({scrollTop: '0'}, 100);
					console.log(response);

					if (response.success == true) {
						$("#changePasswordMessage").html('<div class="alert alert-success alert-dismissible" role="alert">' + 
					  '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' + 
					  '<strong><i class="glyphicon glyphicon-ok-sign"></i></strong>' + response.messages +
						'</div>');

						// remove the mesages
	          $(".alert-success").delay(500).show(10, function() {
							$(this).delay(3000).hide(10, function() {
								$(this).remove();
							});
						}); // /.alert

					} else {
						$("#changePasswordMessage").html('<div class="alert alert-warning alert-dismissible" role="alert">' + 
					  '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' + 
					  '<strong><i class="glyphicon glyphicon-exclamation-sign"></i></strong>' + response.messages +
						'</div>');

						// remove the mesages
	          $(".alert-warning").delay(500).show(10, function() {
							$(this).delay(3000).hide(10, function() {
								$(this).remove();
							});
						}); // /.alert
					}
				}// /success:function
			});// /$.ajax
		}// /else
	return false;
	})// /change password form
});// /document