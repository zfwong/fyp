var manageProductTable;

$(document).ready(function() {
  // top navBrCa bar active
  $("#navBrCa").addClass('active');
  // top navProduct bar active
  $("#navProduct").addClass('active');
  // manage product data table
  manageProductTable = $("#manageProductTable").DataTable({
    'ajax' : 'php_action/fetchProduct.php',
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

  $("#addProductModalBtn").unbind('click').bind('click', function() {
    // alert('ok');
    // product form reset
    $("input[type='text']").val("");
    $("select").val("");
    $('.fileinput-remove-button').click();

    // remove text-error
    $('.text-danger').remove();
    // remove form-group error
    $('.form-group').removeClass('has-error').removeClass('has-success');

    $("#add-product-messages").html('');

    $("#productImage").fileinput({
      overwriteInitial: true,
      maxFileSize: 1500,
      showClose: false,
      showCaption: false,
      browseLabel: '',
      removeLabel: '',
      browseIcon: '<i class="glyphicon glyphicon-folder-open"></i>',
      removeIcon: '<i class="glyphicon glyphicon-remove"></i>',
      removeTitle: 'Cancel or reset changes',
      elErrorContainer: '#kv-avatar-errors-1',
      msgErrorClass: 'alert alert-block alert-danger',
      defaultPreviewContent: '<img src="assets/images/photodefault.png" alt="Default" style="width:160px">',
      layoutTemplates: {main2: '{preview} {remove} {browse}'},
      allowedFileExtensions: ["jpg", "png", "gif"]
    });

    // submit product form
    $("#submitProductForm").unbind('submit').bind('submit', function() {

      // remove text-error
      $('.text-danger').remove();
      // remove form-group error
      $('.form-group').removeClass('has-error').removeClass('has-success');

      var productImage = $("#productImage").val();
      var productName = $("#productName").val();
      var productCost = $("#costperunit").val();
      var quantity = $("#quantity").val();
      var supplier = $("#supplier").val();
      var brandName = $("#brandName").val();
      var categoryName = $("#categoryName").val();
      var productStatus = $("#productStatus").val();

      if (productImage == "") {
        $("#productImage").closest('.center-block').after('<p class="text-danger">The Product Image field is required</p>');
        $("#productImage").closest('.form-group').addClass('has-error');
      } else {
        // remove error text
        $("#productImage").find('.text-danger').remove();
        $("#productImage").closest('.form-group').addClass('has-success');
      }

      if (productName == "") {
        $("#productName").after('<p class="text-danger">The Product Name field is required</p>');
        $("#productName").closest('.form-group').addClass('has-error');
      } else {
        // remove error text
        $("#productName").find('.text-danger').remove();
        $("#productName").closest('.form-group').addClass('has-success');
      }

      if (productCost == "") {
        $("#costperunit").after('<p class="text-danger">The Cost field is required</p>');
        $("#costperunit").closest('.form-group').addClass('has-error');
      } else {
        // remove error text
        $("#costperunit").find('.text-danger').remove();
        $("#costperunit").closest('.form-group').addClass('has-success');
      }

      if (quantity == "") {
        $("#quantity").after('<p class="text-danger">The Quantity field is required</p>');
        $("#quantity").closest('.form-group').addClass('has-error');
      } else {
        // remove error text
        $("#quantity").find('.text-danger').remove();
        $("#quantity").closest('.form-group').addClass('has-success');
      }

      if (supplier == "") {
        $("#supplier").after('<p class="text-danger">The Rate field is required</p>');
        $("#supplier").closest('.form-group').addClass('has-error');
      } else {
        // remove error text
        $("#supplier").find('.text-danger').remove();
        $("#supplier").closest('.form-group').addClass('has-success');
      }

      if (brandName == "") {
        $("#brandName").after('<p class="text-danger">The Brand Name field is required</p>');
        $("#brandName").closest('.form-group').addClass('has-error');
      } else {
        // remove error text
        $("#brandName").find('.text-danger').remove();
        $("#brandName").closest('.form-group').addClass('has-success');
      }

      if (categoryName == "") {
        $("#categoryName").after('<p class="text-danger">The Category Name field is required</p>');
        $("#categoryName").closest('.form-group').addClass('has-error');
      } else {
        // remove error text
        $("#categoryName").find('.text-danger').remove();
        $("#categoryName").closest('.form-group').addClass('has-success');
      }

      if (productStatus == "") {
        $("#productStatus").after('<p class="text-danger">The Product Status field is required</p>');
        $("#productStatus").closest('.form-group').addClass('has-error');
      } else {
        // remove error text
        $("#productStatus").find('.text-danger').remove();
        $("#productStatus").closest('.form-group').addClass('has-success');
      }

      if (productImage && productName && productCost && quantity && supplier && brandName && categoryName && productStatus) {

        var form = $(this);
        var formData = new FormData(this);

        $.ajax({
          url: form.attr('action'),
          type: form.attr('method'),
          data: formData,
          dataType: 'json',
          cache: false,
          contentType: false,
          processData: false,
          success:function(response) {
            if (response.success == true) {
              $("input[type='text']").val("");
              $("select").val("");
              $(".fileinput-remove-button").click();

              $("html, body, div.modal, div.modal-content, div.modal-body").animate({scrollTop: '0'}, 100);

              $("#add-product-messages").html('<div class="alert alert-success alert-dismissible" role="alert">' + 
              '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' + 
              '<strong><i class="glyphicon glyphicon-ok-sign"></i></strong>' + response.messages + 
              '</div>');
              
              $(".alert-success").delay(500).show(10, function() {
                $(this).delay(3000).hide(10, function(){
                  $(this).remove();
                });
              });// /.alert

              // remove text-error
              $('.text-danger').remove();
              // remove form-group error
              $('.form-group').removeClass('has-error').removeClass('has-success');

              // reload the manage product table
              manageProductTable.ajax.reload(null, true);

            } else {
              $("html, body, div.modal, div.modal-content, div.modal-body").animate({scrollTop: '0'}, 100);

              $("#add-product-messages").html('<div class="alert alert-warning alert-dismissible" role="alert">' + 
              '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' + 
              '<strong><i class="glyphicon glyphicon-ok-sign"></i></strong>' + response.messages + 
              '</div>');
              
              $(".alert-warning").delay(500).show(10, function() {
                $(this).delay(3000).hide(10, function(){
                  $(this).remove();
                });
              });// /.alert

              // remove text-error
              $('.text-danger').remove();
              // remove form-group error
              $('.form-group').removeClass('has-error').removeClass('has-success');
            }
          }// /success function
        });// /$.ajax

      }// /if

      return false;
    });// /submit product form

  });// /add product modal btn clicked

});// /document


// edit product function
function editProduct(productId = null) {
  if (productId) {
    // remove product id
    $("#productId").remove();
    // remove text-error
    $('.text-danger').remove();
    // remove form-group error
    $('.form-group').removeClass('has-error').removeClass('has-success');

    $("#edit-product-messages").html('');

    $("#edit-productPhoto-message").html('');

    // alert(productId);
    $.ajax({
      url: 'php_action/fetchSelectedProduct.php',
      type: 'post',
      data:  {productId : productId},
      dataType: 'json',
      success:function(response) {

        $("#getProductImage").attr('src', 'stock/'+response.product_image);

        $("#editProductImage").fileinput({
          overwriteInitial: true,
          maxFileSize: 1500,
          showClose: false,
          showCaption: false,
          browseLabel: '',
          removeLabel: '',
          browseIcon: '<i class="glyphicon glyphicon-folder-open"></i>',
          removeIcon: '<i class="glyphicon glyphicon-remove"></i>',
          removeTitle: 'Cancel or reset changes',
          elErrorContainer: '#kv-avatar-errors-1',
          msgErrorClass: 'alert alert-block alert-danger',
          defaultPreviewContent: '<img src="assets/images/photodefault.png" alt="Default" style="width:160px">',
          layoutTemplates: {main2: '{preview} {remove} {browse}'},
          allowedFileExtensions: ["jpg", "png", "gif"]
        }); 

        $("#editProductName").val(response.product_name);
        $("#editcostperunit").val(response.product_cost);
        $("#editQuantity").val(response.quantity);
        $("#editSupplier").val(response.supplier_id);
        $("#editBrandName").val(response.brand_id);
        $("#editCategoryName").val(response.categories_id);
        $("#editProductStatus").val(response.active);

        $(".editProductFooter").append('<input type="hidden" name="productId" id="productId" value="'+response.product_id+'" />');
        $(".editProductPhotoFooter").append('<input type="hidden" name="productId" id="productId" value="'+response.product_id+'" />');

        $("#updateProductImageForm").unbind('submit').bind('submit', function() {

          // remove text-error
          $('.text-danger').remove();
          // remove form-group error
          $('.form-group').removeClass('has-error').removeClass('has-success');

          var productImage = $("#editProductImage").val();

          if (productImage == "") {
            $("#editProductImage").closest('.center-block').after('<p class="text-danger">The Product Image field is required</p>');
            $("#editProductImage").closest('.form-group').addClass('has-error');
          } else {
            $("#editProductImage").find('.text-danger').remove();
            $("#editProductImage").closest('.form-group').addClass('has-success');
          }

          if (productImage) {
            // alert('ok');
            var form = $(this);
            var formData = new FormData(this);

            $.ajax({
              url: form.attr('action'),
              type: form.attr('method'),
              data: formData,
              dataType: 'json',
              cache: false,
              contentType: false,
              processData: false,
              success:function(response) {
                if (response.success == true) {

                  // remove text-error
                  $('.text-danger').remove();
                  // remove form-group error
                  $('.form-group').removeClass('has-error').removeClass('has-success');

                  $("html, body, div.modal, div.modal-content, div.modal-body").animate({scrollTop: '0'}, 100);

                  $("#edit-productPhoto-message").html('<div class="alert alert-success alert-dismissible" role="alert">' + 
                  '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' + 
                  '<strong><i class="glyphicon glyphicon-ok-sign"></i></strong>' + response.messages + 
                  '</div>');

                  $(".alert-success").delay(500).show(10, function() {
                    $(this).delay(3000).hide(10, function(){
                      $(this).remove();
                    });
                  });// /.alert

                  // reload the manage student table
                  manageProductTable.ajax.reload(null, true);

                  $(".fileinput-remove-button").click();

                  $.ajax({
                    url: 'php_action/fetchProductImageUrl.php?i='+productId,
                    type: 'post',
                    success:function(response) {
                      $("#getProductImage").attr('src', response);
                    }// /success
                  });// /$.ajax
                }// /if
              }// /success
            });// /$.ajax
          }// /if

          return false;
        });

        // update the product data function
        $("#editProductForm").unbind('submit').bind('submit', function() {

          // remove text-error
          $('.text-danger').remove();
          // remove form-group error
          $('.form-group').removeClass('has-error').removeClass('has-success');

          // alert('ok');
          // form validation
          var productName = $("#editProductName").val();
          var quantity = $("#editQuantity").val();
          var productCost = $("#editcostperunit").val();
          var supplier = $("#editSupplier").val();
          var brandName = $("#editBrandName").val();
          var categoryName = $("#editCategoryName").val();
          var productStatus = $("#editProductStatus").val();

          if (productName == "") {
            $("#editProductName").after('<p class="text-danger">The Product Name field is required</p>');
            $("#editProductName").closest('.form-group').addClass('has-error');
          } else {
            // remove error text
            $("#editProductName").find('.text-danger').remove();
            $("#editProductName").closest('.form-group').addClass('has-success');
          }

          if (productCost == "") {
            $("#editcostperunit").after('<p class="text-danger">The Quantity field is required</p>');
            $("#editcostperunit").closest('.form-group').addClass('has-error');
          } else {
            // remove error text
            $("#editcostperunit").find('.text-danger').remove();
            $("#editcostperunit").closest('.form-group').addClass('has-success');
          }

          if (quantity == "") {
            $("#editQuantity").after('<p class="text-danger">The Quantity field is required</p>');
            $("#editQuantity").closest('.form-group').addClass('has-error');
          } else {
            // remove error text
            $("#editQuantity").find('.text-danger').remove();
            $("#editQuantity").closest('.form-group').addClass('has-success');
          }

          if (supplier == "") {
            $("#editSupplier").after('<p class="text-danger">The Rate field is required</p>');
            $("#editSupplier").closest('.form-group').addClass('has-error');
          } else {
            // remove error text
            $("#editSupplier").find('.text-danger').remove();
            $("#editSupplier").closest('.form-group').addClass('has-success');
          }

          if (brandName == "") {
            $("#editBrandName").after('<p class="text-danger">The Brand Name field is required</p>');
            $("#editBrandName").closest('.form-group').addClass('has-error');
          } else {
            // remove error text
            $("#editBrandName").find('.text-danger').remove();
            $("#editBrandName").closest('.form-group').addClass('has-success');
          }

          if (categoryName == "") {
            $("#editCategoryName").after('<p class="text-danger">The Category Name field is required</p>');
            $("#editCategoryName").closest('.form-group').addClass('has-error');
          } else {
            // remove error text
            $("#editCategoryName").find('.text-danger').remove();
            $("#editCategoryName").closest('.form-group').addClass('has-success');
          }

          if (productStatus == "") {
            $("#editProductStatus").after('<p class="text-danger">The Product Status field is required</p>');
            $("#editProductStatus").closest('.form-group').addClass('has-error');
          } else {
            // remove error text
            $("#editProductStatus").find('.text-danger').remove();
            $("#editProductStatus").closest('.form-group').addClass('has-success');
          }

          if (productName && productCost && quantity && supplier && brandName && categoryName && productStatus) {
            // alert('ok');
            var form = $(this);
            $.ajax({
              url: form.attr('action'),
              type: form.attr('method'),
              data: form.serialize(),
              dataType: 'json',
              success:function(response) {
                if (response.success == true) {
                  $("html, body, div.modal, div.modal-content, div.modal-body").animate({scrollTop: '0'}, 100);
                  
                  $("#edit-product-messages").html('<div class="alert alert-success alert-dismissible" role="alert">' + 
                  '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' + 
                  '<strong><i class="glyphicon glyphicon-ok-sign"></i></strong>' + response.messages + 
                  '</div>');

                  $(".alert-success").delay(500).show(10, function() {
                    $(this).delay(3000).hide(10, function(){
                      $(this).remove();
                    });
                  });// /.alert

                  // reload the manage product table
                  manageProductTable.ajax.reload(null, true);

                  // remove text-error
                  $('.text-danger').remove();
                  // remove form-group error
                  $('.form-group').removeClass('has-error').removeClass('has-success');

                }// /if response.success
              }// /success:function
            });// /$.ajax
          } else {
            $("html, body, div.modal, div.modal-content, div.modal-body").animate({scrollTop: '0'}, 100);
            
            $("#edit-product-messages").html('<div class="alert alert-warning alert-dismissible" role="alert">' + 
            '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' + 
            '<strong><i class="glyphicon glyphicon-ok-sign"></i></strong>' + response.messages + 
            '</div>');

            $(".alert-warning").delay(500).show(10, function() {
              $(this).delay(3000).hide(10, function(){
                $(this).remove();
              });
            });// /.alert

            // remove text-error
            $('.text-danger').remove();
            // remove form-group error
            $('.form-group').removeClass('has-error').removeClass('has-success');
          }

          return false;
        });// /update the product data function
      }// /success
    });// /ajax fetch product info
  }// /if productId
}// edit product function


// remove product function
function removeProduct(productId = null) {
  if (productId) {
    // alert(productId);

    // remove product button clicked
    $("#removeProductBtn").unbind('click').bind('click', function() {
      // alert('ok');
      $.ajax({
        url: 'php_action/removeProduct.php',
        type: 'post',
        data: {productId : productId},
        dataType: 'json',
        success:function(response) {
          // close the product modal
          $("#removeProductModal").modal('hide');
          
          if (response.success == true) {

            // update the product table
            manageProductTable.ajax.reload(null, false);

            // remove success message
            $('.remove-messages').html('<div class="alert alert-success alert-dismissible" role="alert">' + 
            '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' + 
            '<strong><i class="glyphicon glyphicon-ok-sign"></i></strong>' + response.messages + 
            '</div>');

            $(".alert-success").delay(500).show(10, function() {
              $(this).delay(3000).hide(10, function(){
                $(this).remove();
              });
            });// /.alert

          } else {
            // remove error message
            $('.remove-messages').html('<div class="alert alert-warning alert-dismissible" role="alert">' + 
            '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' + 
            '<strong><i class="glyphicon glyphicon-exclamation-sign"></i></strong>' + response.messages + 
            '</div>');

            $(".alert-warning").delay(500).show(10, function() {
              $(this).delay(3000).hide(10, function(){
                $(this).remove();
              });
            });// /.alert
          }
        }// /success:function
      });// /$.ajax
    });// /remove product button clicked 
  }// /if productId
}// /remove product function