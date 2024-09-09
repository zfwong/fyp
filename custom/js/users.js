var manageUserTable;

$(document).ready(function() {
	// active navUser bar
	$("#navUser").addClass('active');
	// active top navManageUsers bar
	$("#topNavManageUsers").addClass('active');

	// manage User Table
	manageUserTable = $("#manageUserTable").DataTable({
		'ajax' : 'php_action/fetchUsers.php',
		'order' : []
	});

	$("#showHelpModal").on('hide.bs.modal', function() {
    $("#collapseH1").collapse('hide');
    $("#collapseH2").collapse('hide');
    $("#collapseH3").collapse('hide');
  });
	
	$('.content-container').addClass('body-loaded');
	
	$('.bottom-fixed').fadeOut('slow');
});

function addUser() {
	// reset the form text
	$("#createUserForm")[0].reset();
	// remove error text
	$(".text-danger").remove();
	// remove the form error
	$(".form-group").removeClass('has-error').removeClass('has-success');

	// submit brand form function
	$("#createUserForm").unbind('submit').bind('submit', function(){

		// remove error text
		$(".text-danger").remove();
		// remove the form error
		$(".form-group").removeClass('has-error').removeClass('has-success');

		var userLevel = $("#userLevel").val();
		var userName = $("#userName").val();
		var userPass = $("#userPass").val();
		var firstName = $("#firstName").val();
		var lastName = $("#lastName").val();
		var eMail = $("#eMail").val();


		if(userLevel == "") {
			$("#userLevel").after('<p class="text-danger">User Level field is required</p>');
			$("#userLevel").closest('.form-group').addClass('has-error');
		} else {
			// remove error text field
			$("#userLevel").find('.text-danger').remove();
			$("#userLevel").closest('.form-group').addClass('has-success');
		}

		if(userName == "") {
			$("#userName").after('<p class="text-danger">Username field is required</p>');
			$("#userName").closest('.form-group').addClass('has-error');
		} else {
			// remove error text field
			$("#userName").find('.text-danger').remove();
			$("#userName").closest('.form-group').addClass('has-success');
		}

		if(userPass == "") {
			$("#userPass").after('<p class="text-danger">Password field is required</p>');
			$("#userPass").closest('.form-group').addClass('has-error');
		} else {
			// remove error text field
			$("#userPass").find('.text-danger').remove();
			$("#userPass").closest('.form-group').addClass('has-success');
		}

		if(firstName == "") {
			$("#firstName").after('<p class="text-danger">First Name field is required</p>');
			$("#firstName").closest('.form-group').addClass('has-error');
		} else {
			// remove error text field
			$("#firstName").find('.text-danger').remove();
			$("#firstName").closest('.form-group').addClass('has-success');
		}

		if(lastName == "") {
			$("#lastName").after('<p class="text-danger">Last Name field is required</p>');
			$("#lastName").closest('.form-group').addClass('has-error');
		} else {
			// remove error text field
			$("#lastName").find('.text-danger').remove();
			$("#lastName").closest('.form-group').addClass('has-success');
		}

		if (eMail && /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(eMail)) {
			// remove error text field
			$("#eMail").find('.text-danger').remove();
			$("#eMail").closest('.form-group').addClass('has-success');
		} else if (eMail != "" && /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(eMail) == false) {
			$("#eMail").after('<p class="text-danger">E-mail field format is incorrect</p>');
			$("#eMail").closest('.form-group').addClass('has-error');
			return false;
		}

		if(userLevel && userName && userPass && firstName && lastName) {
			var form = $(this);

			// button loading
			$("#createUserBtn").button('loading');
			
			$.ajax({
				url: form.attr('action'),
				type: form.attr('method'),
				data: form.serialize(),
				dataType: 'json',
				success:function(response) {
					// button loading
					$("#createUserBtn").button('reset');

					if(response.success == true) {

						manageUserTable.ajax.reload(null, false);

	          $("html, body, div.modal, div.modal-content, div.modal-body").stop(true, true).animate({scrollTop: '0'}, 100);

						// reset the form text
						$("#createUserForm")[0].reset();
						// remove error text
						$(".text-danger").remove();
						// remove the form error
						$(".form-group").removeClass('has-error').removeClass('has-success');

						$('.add-user-messages').html('<div class="alert alert-success">' +
  					'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
  					'<strong><i class="glyphicon glyphicon-ok-sign"></i></strong>' + response.messages +
						'</div>');

						$(".alert-success").delay(500).show(10, function() {
							$(this).delay(3000).hide(10, function(){
								$(this).remove();
							});
						});// /.alert
					} else {
						$('.add-user-messages').html('<div class="alert alert-warning">' +
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
		}

		return false;
	});// /submit create user form function
}// /addUser function

function editUser(userId = null) {
	if (userId) {
		// remove brandID
		$("#userId").remove();
		// refresh the form
		$("#editUserForm")[0].reset();
		// remove text
		$(".text-danger").remove();
		// remove form error
		$(".form-group").removeClass('has-error').removeClass('has-success');

		$(".editUserFooter").after('<input type="hidden" name="userId" id="userId" value="'+ userId +'" />');
		
		$.ajax({
			url: 'php_action/fetchSelectedUsers.php',
			type: 'post',
			data: {userId : userId},
			dataType: 'json',
			success:function(response) {
				$("#editUserLevel").val(response.user_level);
				$("#editUserName").val(response.username);
				$("#editFirstName").val(response.firstname);
				$("#editLastName").val(response.lastname);
				$("#editEMail").val(response.email);

				// submit edit user form
				$("#editUserForm").unbind('submit').bind('submit', function(){
					// remove the error text
					$(".text-danger").remove();
					// remove the form error
					$(".form-group").removeClass('has-error').removeClass('has-success');

					var userLevel = $("#editUserLevel").val();
					var userName = $("#editUserName").val();
					var firstName = $("#editFirstName").val();
					var lastName = $("#editLastName").val();
					var eMail = $("#editEMail").val();

					if(userLevel == "") {
						$("#editUserLevel").after('<p class="text-danger">Brand Name field is required</p>');
						$("#editUserLevel").closest('.form-group').addClass('has-error');
					} else {
						// remove error text field
						$("#editUserLevel").find('.text-danger').remove();
						$("#editUserLevel").closest('.form-group').addClass('has-success');
					}

					if(userName == "") {
						$("#editUserName").after('<p class="text-danger">Brand Status field is required</p>');
						$("#editUserName").closest('.form-group').addClass('has-error');
					} else {
						// remove error text field
						$("#editUserName").find('.text-danger').remove();
						$("#editUserName").closest('.form-group').addClass('has-success');
					}

					if(firstName == "") {
						$("#editFirstName").after('<p class="text-danger">Brand Status field is required</p>');
						$("#editFirstName").closest('.form-group').addClass('has-error');
					} else {
						// remove error text field
						$("#editFirstName").find('.text-danger').remove();
						$("#editFirstName").closest('.form-group').addClass('has-success');
					}

					if(lastName == "") {
						$("#editLastName").after('<p class="text-danger">Brand Status field is required</p>');
						$("#editLastName").closest('.form-group').addClass('has-error');
					} else {
						// remove error text field
						$("#editLastName").find('.text-danger').remove();
						$("#editLastName").closest('.form-group').addClass('has-success');
					}

					if (eMail && /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(eMail)) {
						// remove error text field
						$("#editEMail").find('.text-danger').remove();
						$("#editEMail").closest('.form-group').addClass('has-success');
					} else if (eMail != "" && /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(eMail) == false) {
						$("#editEMail").after('<p class="text-danger">E-mail field format is incorrect</p>');
						$("#editEMail").closest('.form-group').addClass('has-error');
						return false;
					}

					if(userLevel && userName && firstName && lastName) {
						var form = $(this);

						$.ajax({
							url: form.attr('action'),
							type: form.attr('method'),
							data: form.serialize(),
							dataType: 'json',
							success:function(response) {
								if(response.success == true) {
									// reload the manage member table
									manageUserTable.ajax.reload(null, false);

			            $("html, body, div.modal, div.modal-content, div.modal-body").stop(true, true).animate({scrollTop: '0'}, 100);
									// remove error text
									$(".text-danger").remove();
									// remove the form error
									$(".form-group").removeClass('has-error').removeClass('has-success');

									$(".edit-user-messages").html('<div class="alert alert-success">' +
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
						});
					}

					return false;
				});// /submit edit user form
			}// /success:function()
		});// /$.ajax
	}// /if(userId)
}// /editUser function

function removeUser(userId = null) {
	if (userId) {
		$("#removeUserBtn").unbind('click').bind('click', function() {
			$.ajax({
				url: 'php_action/removeUsers.php',
				type: 'post',
				data: {userId : userId},
				dataType: 'json',
				success:function(response) {
					if (response.success == true) {
						// hide the modal
						$("#removeUserModal").modal('hide');

            $("html, body, div.modal, div.modal-content, div.modal-body").stop(true, true).animate({scrollTop: '0'}, 100);

						// reload the user table
						manageUserTable.ajax.reload(null, false);

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
	}// /if(userId)
}// /removeUser function	