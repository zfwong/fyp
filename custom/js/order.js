var manageOrderTable;
$(document).ready(function() {
	$("#orderDate").datetimepicker({
		useCurrent: false,
		showClear: true,
		format: 'DD-MM-YYYY',
		widgetPositioning: {
			horizontal: 'left',
			vertical: 'bottom',
		},
	});

	$("#showManordHelpModal").on('hide.bs.modal', function() {
		$("#collapseH1").collapse('hide');
		$("#collapseH2").collapse('hide');
		$("#collapseH3").collapse('hide');
		$("#collapseH4").collapse('hide');
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

	var divRequest = $('.div-request').text();

	// active navOrder bar
	$("#navOrder").addClass('active');

	// active top navAddOrder bar
	if (divRequest == 'add') {
		$("#topNavAddOrder").addClass('active');

		$("#createOrderForm").unbind('submit').bind('submit', function() {
			var form = $(this);

			$('.form-group').removeClass('has-error').removeClass('has-success');
			$('.text-danger').remove();

			var orderDate = $("#orderDate").val();
			var orderSupplier = $("#orderSupplier").val();
			var paymentMethod = $("#paymentMethod").val();
			var paidAmount = $("#paid").val();

			if(orderDate == "") {
				$("#orderDate").after('<p class="text-danger">Order Date field is required</p>');
				$("#orderDate").closest('.form-group').addClass('has-error');
			} else {
				$("#orderDate").find('.text-danger').remove();
				$("#orderDate").closest('.form-group').addClass('has-success');
			}

			if(orderSupplier == "") {
				$("#orderSupplier").after('<p class="text-danger">Supplier field is required</p>');
				$("#orderSupplier").closest('.form-group').addClass('has-error');
			} else {
				$("#orderSupplier").find('.text-danger').remove();
				$("#orderSupplier").closest('.form-group').addClass('has-success');
			}

			if(paymentMethod == "") {
				$("#paymentMethod").after('<p class="text-danger">Payment Method field is required</p>');
				$("#paymentMethod").closest('.form-group').addClass('has-error');
			} else {
				$("#paymentMethod").find('.text-danger').remove();
				$("#paymentMethod").closest('.form-group').addClass('has-success');
			}

			if (paidAmount && /^(\d+|\d+\.\d{2}|\d+\.\d{1})$/.test(paidAmount) == false) {
				$("#paid").after('<p class="text-danger">Paid field does not match required format</p>');
				$("#paid").closest('.form-group').addClass('has-error');
			} else if (paidAmount && /^(\d+|\d+\.\d{2}|\d+\.\d{1})$/.test(paidAmount)) {
				$("#paid").find('.text-danger').remove();
				$("#paid").closest('.form-group').addClass('has-success');
			} else if (paidAmount == "") {				
				$("#paid").after('<p class="text-danger">Paid field is required</p>');
				$("#paid").closest('.form-group').addClass('has-error');
			}

			var productName = document.getElementsByName('productName[]');
			var validateProduct;
			for (var x = 0; x < productName.length; x++) {
				var productNameId = productName[x].id;
				if (productName[x].value == '') {
					$("#"+productNameId+"").after('<p class="text-danger">Product field is required</p>');
					$("#"+productNameId+"").closest('.form-group').addClass('has-error');
				} else {
					$("#"+productNameId+"").find('.text-danger').remove();
					$("#"+productNameId+"").closest('.form-group').addClass('has-success');
				}
			}

			for (var x = 0; x < productName.length; x++) {
				if (productName[x].value) {
					validateProduct = true;
				} else {
					validateProduct = false;
				}
			}

			var quantity = document.getElementsByName('productQty[]');
			var validateQuantity;
			for (var x = 0; x < quantity.length; x++) {
				var quantityId = quantity[x].id;
				if (quantity[x].value == '') {
					$("#"+quantityId+"").after('<p class="text-danger">Quantity field is required</p>');
					$("#"+quantityId+"").closest('.form-group').addClass('has-error');
				} else {
					$("#"+quantityId+"").find('.text-danger').remove();
					$("#"+quantityId+"").closest('.form-group').addClass('has-success');
				}
			}

			for (var x = 0; x < quantity.length; x++) {
				if (quantity[x].value) {
					validateQuantity = true;
				} else {
					validateQuantity = false;
				}
			}

			if (orderDate && orderSupplier && paymentMethod && paidAmount && /^(\d+|\d+\.\d{2}|\d+\.\d{1})$/.test(paidAmount)) {
				if (validateProduct == true && validateQuantity == true) {
					$.ajax({
						url: form.attr('action'),
						type: form.attr('method'),
						data: form.serialize(),
						dataType: 'json',
						success:function(response) {
							$(".text-danger").remove();
							$('.form-group').removeClass('has-error').removeClass('has-success');

							if (response.success == true) {
								$("#createOrderForm")[0].reset();

								$(".success-messages").html('<div class="alert alert-success">' +
		  						'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
		  						'<strong><i class="glyphicon glyphicon-ok-sign"></i></strong>' + response.messages +
									'</div>');

							  $("html, body, div.modal, div.modal-content, div.modal-body").stop(true, true).animate({scrollTop: '0'}, 200);
							
							  $(".alert-success").delay(500).show(10, function() {
									$(this).delay(3000).hide(10, function(){
										$(this).remove();
									});
								});
							}
						}
					});
				}
			}

			return false;
		});
	
	} else if (divRequest == 'manord') {
		$("#topNavManageOrder").addClass('active');

		manageOrderTable = $("#manageOrderTable").DataTable({
			'ajax' : 'php_action/fetchOrder.php',
			'order' : []
		});

	} else if (divRequest == 'editOrd') {
		$("#editOrderForm").unbind('submit').bind('submit', function() {
			var form = $(this);

			$('.form-group').removeClass('has-error').removeClass('has-success');
			$('.text-danger').remove();

			var orderDate = $("#orderDate").val();
			var orderSupplier = $("#orderSupplier").val();
			var paymentMethod = $("#paymentMethod").val();
			var paidAmount = $("#paid").val();
			var orderStatus = $("#orderStatus").val();

			if(orderDate == "") {
				$("#orderDate").after('<p class="text-danger">Order Date field is required</p>');
				$("#orderDate").closest('.form-group').addClass('has-error');
			} else {
				$("#orderDate").find('.text-danger').remove();
				$("#orderDate").closest('.form-group').addClass('has-success');
			}

			if(orderSupplier == "") {
				$("#orderSupplier").after('<p class="text-danger">Supplier field is required</p>');
				$("#orderSupplier").closest('.form-group').addClass('has-error');
			} else {
				$("#orderSupplier").find('.text-danger').remove();
				$("#orderSupplier").closest('.form-group').addClass('has-success');
			}

			if(paymentMethod == "") {
				$("#paymentMethod").after('<p class="text-danger">Payment Method field is required</p>');
				$("#paymentMethod").closest('.form-group').addClass('has-error');
			} else {
				$("#paymentMethod").find('.text-danger').remove();
				$("#paymentMethod").closest('.form-group').addClass('has-success');
			}

			if(orderStatus == "") {
				$("#orderStatus").after('<p class="text-danger">Order field is required</p>');
				$("#orderStatus").closest('.form-group').addClass('has-error');
			} else {
				$("#orderStatus").find('.text-danger').remove();
				$("#orderStatus").closest('.form-group').addClass('has-success');
			}

			if (paidAmount && /^(\d+|\d+\.\d{2}|\d+\.\d{1})$/.test(paidAmount) == false) {
				$("#paid").after('<p class="text-danger">Paid field does not match required format</p>');
				$("#paid").closest('.form-group').addClass('has-error');
			} else if (paidAmount && /^(\d+|\d+\.\d{2}|\d+\.\d{1})$/.test(paidAmount)) {
				$("#paid").find('.text-danger').remove();
				$("#paid").closest('.form-group').addClass('has-success');
			} else if (paidAmount == "") {				
				$("#paid").after('<p class="text-danger">Paid field is required</p>');
				$("#paid").closest('.form-group').addClass('has-error');
			}

			var productName = document.getElementsByName('productName[]');
			var validateProduct;
			for (var x = 0; x < productName.length; x++) {
				var productNameId = productName[x].id;
				if (productName[x].value == '') {
					$("#"+productNameId+"").after('<p class="text-danger">Product field is required</p>');
					$("#"+productNameId+"").closest('.form-group').addClass('has-error');
				} else {
					$("#"+productNameId+"").find('.text-danger').remove();
					$("#"+productNameId+"").closest('.form-group').addClass('has-success');
				}
			}

			for (var x = 0; x < productName.length; x++) {
				if (productName[x].value) {
					validateProduct = true;
				} else {
					validateProduct = false;
				}
			}

			var quantity = document.getElementsByName('productQty[]');
			var validateQuantity;
			for (var x = 0; x < quantity.length; x++) {
				var quantityId = quantity[x].id;
				if (quantity[x].value == '') {
					$("#"+quantityId+"").after('<p class="text-danger">Quantity field is required</p>');
					$("#"+quantityId+"").closest('.form-group').addClass('has-error');
				} else {
					$("#"+quantityId+"").find('.text-danger').remove();
					$("#"+quantityId+"").closest('.form-group').addClass('has-success');
				}
			}

			for (var x = 0; x < quantity.length; x++) {
				if (quantity[x].value) {
					validateQuantity = true;
				} else {
					validateQuantity = false;
				}
			}

			if (orderDate && orderSupplier && paymentMethod && paidAmount && orderStatus && /^(\d+|\d+\.\d{2}|\d+\.\d{1})$/.test(paidAmount)) {
				if (validateProduct == true && validateQuantity == true) {
					$.ajax({
						url: form.attr('action'),
						type: form.attr('method'),
						data: form.serialize(),
						dataType: 'json',
						success:function(response) {
							$(".text-danger").remove();
							$('.form-group').removeClass('has-error').removeClass('has-success');

							if (response.success == true) {

								$(".success-messages").html('<div class="alert alert-success">' +
		  						'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
		  						'<strong><i class="glyphicon glyphicon-ok-sign"></i></strong>' + response.messages +
									'</div>');

							  $("html, body, div.modal, div.modal-content, div.modal-body").stop(true, true).animate({scrollTop: '0'}, 200);
							
							  $(".alert-success").delay(500).show(10, function() {
									$(this).delay(3000).hide(10, function(){
										$(this).remove();
									});
								});
							}
						}
					});
				}
			}

			return false;
		});
	}
});

function getSupplierData() {
	var supplierId = $("#orderSupplier").val();
	if (supplierId == "") {
		$("#orderContact").val('');
	} else {
		$.ajax({
			url: 'php_action/fetchSelectedSuppliers.php',
			type: 'post',
			data: {supplierId : supplierId},
			dataType: 'json',
			success:function(response) {
				$("#orderContact").val(response.supplier_contact);
			}
		});
	}
}

function addProductRow() {
	var tableLength = $("#productTable tbody tr").length;
	var tableRow;
	var arrayNumber;
	var count;

	if (tableLength > 0) {
		tableRow = $("#productTable tbody tr:last").attr('id');
		arrayNumber = $("#productTable tbody tr:last").attr('class');
		count = tableRow.substring(3);
		arrayNumber = Number(arrayNumber) + 1;
		count = Number(count) + 1;
	} else {
		count = 1;
		arrayNumber = 0;
	}

	$.ajax({
		url: 'php_action/fetchProductData.php',
		type: 'post',
		dataType: 'json',
		success:function(response) {
			var tr = 
			'<tr id="row'+count+'" class="'+arrayNumber+'">'+
				'<td>'+
					'<div class="form-group">'+
						'<select class="form-control" name="productName[]" id="productName'+count+'" onchange="getProductData('+count+')" style="width: 97%">'+
							'<option value="">~~SELECT~~</option>';
							$.each(response, function(index, value) {
								tr += '<option value="'+value[0]+'">'+value[1]+'</option>';
							});
						tr += '</select>'+
					'</div>'+
				'</td>'+
				'<td>'+
					'<input type="text" class="form-control" name="productCost[]" id="productCost'+count+'" readonly="true">'+
					'<input type="hidden" class="form-control" name="productCostValue[]" id="productCostValue'+count+'">'+
				'</td>'+
				'<td style="padding-left: 20px">'+
					'<div class="form-group">'+
						'<input type="number" class="form-control" name="productQty[]" id="productQty'+count+'" min="1" onkeyup="getTotal('+count+')" onchange="getTotal('+count+')" autocomplete="off">'+
					'</div>'+
				'</td>'+
				'<td style="padding-left: 20px">'+
					'<input type="text" class="form-control" name="productTotal[]" id="productTotal'+count+'" readonly="true">'+
					'<input type="hidden" class="form-control" name="productTotalValue[]" id="productTotalValue'+count+'">'+					
				'</td>'+
				'<td>'+
					'<button type="button" class="btn btn-default" id="removeProductRowBtn" onclick="removeProductRow('+count+')"><i class="glyphicon glyphicon-trash"></i></button>'+
				'</td>'+	
		 '</tr>';
		 if (tableLength > 0) {
		 	$("#productTable tbody tr:last").after(tr);
		 } else {
		 	$("#productTable tbody").append(tr);
		 }
		}// /success:function()
	});
}

function getProductData(row = null) {
	if (row) {
		var productId = $("#productName"+row).val();
		if (productId == "") {
			$("#productCost"+row).val("");
			$("#productQty"+row).val("");
			$("#productTotal"+row).val("");
		} else {
			$.ajax({
				url: 'php_action/fetchSelectedProduct.php',
				type: 'post',
				data: {productId : productId},
				dataType: 'json',
				success:function(response) {
					$("#productCost"+row).val(response.product_cost);
					$("#productCostValue"+row).val(response.product_cost);					

					$("#productQty"+row).val(1);

					var total = Number(response.product_cost) * 1;
					total = total.toFixed(2);
					$("#productTotal"+row).val(total);
					$("#productTotalValue"+row).val(total);

					calculation();
				}
			});
		}
	}
}

function getTotal(row = null) {
	if (row) {
		var total = Number($("#productCost"+row).val()) * Number($("#productQty"+row).val());
		total = total.toFixed(2);
		$("#productTotal"+row).val(total);
		$("#productTotalValue"+row).val(total);

		calculation();
	}
}

function removeProductRow(row = null) {
	if (row) {
		$("#row"+row).remove();

		calculation();
	}
}

function calculation() {
	var tableProductLength = $("#productTable tbody tr").length;
	var totalSubTotal = 0;
	for (x = 0; x < tableProductLength; x++) {
		var tr = $("#productTable tbody tr")[x];
		var count = $(tr).attr('id');
		count = count.substring(3);

		totalSubTotal = Number(totalSubTotal) + Number($("#productTotal"+count).val());
	}

	totalSubTotal = totalSubTotal.toFixed(2);

	$("#subTotal").val(totalSubTotal);
	$("#subTotalValue").val(totalSubTotal);

	var gst = (Number($("#subTotal").val())/100) * 6;
	gst = gst.toFixed(2);
	$("#gst").val(gst);
	$("#gstValue").val(gst);

	var grandTotal = Number($("#subTotal").val()) + Number($("#gst").val());
	grandTotal = grandTotal.toFixed(2);
	$("#grandTotal").val(grandTotal);
	$("#grandTotalValue").val(grandTotal);

	var paidAmount = $("#paid").val();
	if (paidAmount) {
		var due = Number($("#grandTotal").val()) - Number(paidAmount);
		due = due.toFixed(2);
		$("#due").val(due);
		$("#dueValue").val(due);
	} else {
		$("#due").val($("#grandTotal").val());
		$("#dueValue").val($("#grandTotal").val());
	}
}

function getPaidAmount() {
	var grandTotal = $("#grandTotal").val();

	if (grandTotal) {
		var dueAmount = Number($("#grandTotal").val()) - Number($("#paid").val());
		dueAmount = dueAmount.toFixed(2);
		$("#due").val(dueAmount);
		$("#dueValue").val(dueAmount);
	}
}

function resetOrderForm() {
	// reset the input field
	$("#createOrderForm")[0].reset();
	// remove remove text danger
	$(".text-danger").remove();
	// remove form group error 
	$(".form-group").removeClass('has-success').removeClass('has-error');
	// clear date picked
	$("#orderDate").data('DateTimePicker').clear();
	// scroll top
  $("html, body, div.modal, div.modal-content, div.modal-body").stop(true, true).animate({scrollTop: '0'}, 300);
}

function removeOrder(orderId = null) {
	if (orderId) {
		$("#removeOrderBtn").unbind('click').bind('click', function() {
			$("#removeOrderBtn").button('loading');

			$.ajax({
				url: 'php_action/removeOrder.php',
				type: 'post',
				data: {orderId : orderId},
				dataType: 'json',
				success:function(response) {
					$("#removeOrderBtn").button('reset');
					if (response.success == true) {
						manageOrderTable.ajax.reload(null, false);
						$("#removeOrderModal").modal('hide');
						$(".success-messages").html('<div class="alert alert-success">' +
							'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
							'<strong><i class="glyphicon glyphicon-ok-sign"></i></strong>' + response.messages +
							'</div>');

						$(".alert-success").delay(500).show(10, function() {
							$(this).delay(3000).hide(10, function(){
								$(this).remove();
							});
						});
					} else {
						$("#removeOrderModal").modal('hide');
						$(".success-messages").html('<div class="alert alert-warning">' +
							'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
							'<strong><i class="glyphicon glyphicon-exclamation-sign"></i></strong>' + response.messages +
							'</div>');

						$(".alert-warning").delay(500).show(10, function() {
							$(this).delay(3000).hide(10, function(){
								$(this).remove();
							});
						});
					}
				}
			});
		});
	}
}

function printOrder(orderId = null) {
	if (orderId) {
		$.ajax({
			url: 'php_action/printOrder.php',
			type: 'post',
			data: {orderId : orderId},
			dataType: 'text',
			success:function(response) {
				var mywindow = window.open('', 'Inventory Management System', 'height=400,width=600');
				mywindow.document.write('<html><head><title>Order Invoice</title>');
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
}