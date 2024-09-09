<?php require_once 'includes/header.php'; ?>

<div class="row">
	<div class="col-md-12">
		<ol class="breadcrumb">
		  <li><a href="dashboard.php">Home</a></li>
		  <li>Inventory</li>
			<li class="active">Stock</li>
		</ol>

		<div class="panel panel-info plus">
		  <div class="panel-heading"><i class="fa fa-list"></i>&nbsp;&nbsp;Stock List&nbsp;&nbsp;<a class="glyphicon glyphicon-question-sign" title="Help" data-toggle="modal" data-target="#showHelpModal"></a></div>
		  <div class="panel-body">
		    <div class="remove-messages"></div>

		    <div class="div-action pull pull-right" style="padding-bottom: 20px;">
		    	<button class="btn btn-default" data-toggle="modal" data-target="#addProductModal" id="addProductModalBtn"><i class="glyphicon glyphicon-plus-sign"></i>&nbsp;&nbsp;Add Product</button>
		    </div>

		    <table class="table" id="manageProductTable" style="width: 100%">
		    	<thead>
		    		<tr>
		    			<th style="width: 10%;">Photo</th>
		    			<th>Product Name</th>
		    			<th>Supplier</th>
		    			<th style="width: 15%">Cost/unit (RM)</th>
		    			<th>Quantity</th>
		    			<th>Brand</th>
		    			<th>Category</th>
		    			<th>Status</th>
		    			<th style="width: 10%;">Options</th>
		    		</tr>
		    	</thead>
		    </table>

		  </div>
		</div>

	</div>
</div>

<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" id="addProductModal">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background: url(../stock_system/custom/css/bg-image3.jpg) center fixed no-repeat;background-size: cover;color: white;border-radius: 5px 5px 0 0;">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add Product</h4>
      </div>

      <form class="form-horizontal" id="submitProductForm" action="php_action/createProduct.php" method="post" enctype="multipart/form-data">

	      <div class="modal-body" style="max-height: 450px; overflow: auto;">

	      <div id="add-product-messages"></div>

				  <div class="form-group">
				    <label for="productImage" class="col-sm-3 control-label">Product Image :</label>
				    <div class="col-sm-9">

							<div id="kv-avatar-errors-1" class="center-block" style="width: 800px;display: none;"></div>
							<div class="kv-avatar center-block">
							  <input id="productImage" name="productImage" type="file" class="file-loading">
							</div>

				    </div>
				  </div>

				  <div class="form-group">
				    <label for="productName" class="col-sm-3 control-label">Product Name :</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="productName" name="productName" placeholder="Product Name" autocomplete="off">
				    </div>
				  </div>

				  <div class="form-group">
				    <label for="costperunit" class="col-sm-3 control-label">Cost / unit (RM):</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="costperunit" name="costperunit" placeholder="Cost" autocomplete="off">
				    </div>
				  </div>
				  
				  <div class="form-group">
				    <label for="quantity" class="col-sm-3 control-label">Quantity :</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="quantity" name="quantity" placeholder="Quantity" autocomplete="off">
				    </div>
				  </div>

				  <div class="form-group">
				    <label for="supplier" class="col-sm-3 control-label">Supplier :</label>
				    <div class="col-sm-9">
				      <select class="form-control" id="supplier" name="supplier">
				      	<option value="">~~SELECT~~</option>
				      	<?php
				      	$sql = "SELECT supplier_id, supplier_name FROM supplier WHERE supplier_status = 1 AND supplier_active = 1";
				      	$result = $connect->query($sql);
				      	while ($row = $result->fetch_array()) {
				      		echo "<option value='".$row[0]."'>".$row[1]."</option>"; 	
				      	} 
				      	?>
				      </select>
				    </div>
				  </div>

				  <div class="form-group">
				    <label for="brandName" class="col-sm-3 control-label">Brand Name :</label>
				    <div class="col-sm-9">
				      <select class="form-control" id="brandName" name="brandName">
				      	<option value="">~~SELECT~~</option>
				      	<?php
				      	$sql = "SELECT brand_id, brand_name FROM brands WHERE brand_status = 1 AND brand_active = 1";
				      	$result = $connect->query($sql);
				      	while ($row = $result->fetch_array()) {
				      		echo "<option value='".$row[0]."'>".$row[1]."</option>"; 	
				      	} 
				      	?>
				      </select>
				    </div>
				  </div>

				  <div class="form-group">
				    <label for="categoryName" class="col-sm-3 control-label">Category Name :</label>
				    <div class="col-sm-9">
				      <select class="form-control" id="categoryName" name="categoryName">
				      	<option value="">~~SELECT~~</option>
				      	<?php 
				      	$sql = "SELECT categories_id, categories_name FROM category WHERE categories_active = 1 AND categories_status = 1";
				      	$result = $connect->query($sql);
				      	while ($row = $result->fetch_array()) {
				      		echo "<option value='".$row[0]."'>".$row[1]."</option>";
				      	}
				      	?>
				      </select>
				    </div>
				  </div>

				  <div class="form-group">
				    <label for="productStatus" class="col-sm-3 control-label">Status :</label>
				    <div class="col-sm-9">
				    	<select class="form-control" id="productStatus" name="productStatus">
				    		<option value="">~~SELECT~~</option>
				    		<option value="1">Available</option>
				    		<option value="2">Not Available</option>
				    	</select>
				    </div>
				  </div>

	      </div><!-- /modal-body -->

	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	        <button type="submit" class="btn btn-primary">Save changes</button>
	      </div>

	    </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" id="editProductModal">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background: url(../stock_system/custom/css/bg-image3.jpg) center fixed no-repeat;background-size: cover;color: white;border-radius: 5px 5px 0 0;">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-edit"></i>&nbsp;&nbsp;Edit Product</h4>
      </div>
      <div class="modal-body" style="height: 450px; overflow: auto;">

			  <!-- Nav tabs -->
			  <ul class="nav nav-tabs" role="tablist">
			    <li role="presentation" class="active"><a href="#photo" aria-controls="home" role="tab" data-toggle="tab">Photo</a></li>
			    <li role="presentation"><a href="#productInfo" aria-controls="profile" role="tab" data-toggle="tab">Product Info</a></li>
			  </ul>

			  <!-- Tab panes -->
			  <div class="tab-content">
			    <div role="tabpanel" class="tab-pane fade in active" id="photo">
			    	
			    	<form class="form-horizontal" id="updateProductImageForm" action="php_action/editProductImage.php" method="POST" enctype="multipart/form-data">

			    	<br />
			    	<div id="edit-productPhoto-message"></div>
						  <div class="form-group">
						    <label for="getProductImage" class="col-sm-3 control-label">Product Image</label>
						    <div class="col-sm-9">
						    	<img src="" id="getProductImage" class="thumbnail" style="width: 250px;height: 250px";>
						    </div>
						  </div>
						  <div class="form-group">
						    <label for="editProductImage" class="col-sm-3 control-label">Product Image</label>
						    <div class="col-sm-9">
						  		<div id="kv-avatar-errors-1" class="center-block" style="width: 800px;display: none"></div>
						  		<div class="kv-avatar center-block">
							      <input id="editProductImage" name="editProductImage" type="file" class="file-loading">
							    </div>
						    </div>
						  </div>
						  <div class="modal-footer editProductPhotoFooter">
						  	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      					<button type="submit" class="btn btn-primary">Save changes</button>
						  </div>
						</form>

			    </div>
			    <!-- /photo -->
			    <div role="tabpanel" class="tab-pane fade" id="productInfo">
			    <br />

			    <div id="edit-product-messages"></div>

			    	<form class="form-horizontal" id="editProductForm" action="php_action/editProduct.php" method="POST">
						  <div class="form-group">
						    <label for="editProductName" class="col-sm-3 control-label">Product Name :</label>
						    <div class="col-sm-9">
						      <input type="text" class="form-control" id="editProductName" name="editProductName" placeholder="Product Name" autocomplete="off">
						    </div>
						  </div>

						  <div class="form-group">
						    <label for="editcostperunit" class="col-sm-3 control-label">Cost / unit (RM):</label>
						    <div class="col-sm-9">
						      <input type="text" class="form-control" id="editcostperunit" name="editcostperunit" placeholder="Cost" autocomplete="off">
						    </div>
						  </div>

						  <div class="form-group">
						    <label for="editQuantity" class="col-sm-3 control-label">Quantity :</label>
						    <div class="col-sm-9">
						      <input type="text" class="form-control" id="editQuantity" name="editQuantity" placeholder="Quantity" autocomplete="off">
						    </div>
						  </div>

						  <div class="form-group">
						    <label for="editSupplier" class="col-sm-3 control-label">Supplier :</label>
						    <div class="col-sm-9">
						      <select class="form-control" id="editSupplier" name="editSupplier">
						      	<option value="">~~SELECT~~</option>
						      	<?php
						      	$sql = "SELECT supplier_id, supplier_name FROM supplier WHERE supplier_status = 1 AND supplier_active = 1";
						      	$result = $connect->query($sql);

						      	while ($row = $result->fetch_array()) {
						      		echo "<option value='".$row[0]."'>".$row[1]."</option>";
						      	}
						      	?>
						      </select>
						    </div>
						  </div>

						  <div class="form-group">
						    <label for="editBrandName" class="col-sm-3 control-label">Brand Name :</label>
						    <div class="col-sm-9">
						      <select class="form-control" id="editBrandName" name="editBrandName">
						      	<option value="">~~SELECT~~</option>
						      	<?php
						      	$sql = "SELECT brand_id, brand_name FROM brands WHERE brand_status = 1 AND brand_active = 1";
						      	$result = $connect->query($sql);

						      	while ($row = $result->fetch_array()) {
						      		echo "<option value='".$row[0]."'>".$row[1]."</option>";
						      	}
						      	?>
						      </select>
						    </div>
						  </div>

						  <div class="form-group">
						    <label for="editCategoryName" class="col-sm-3 control-label">Category Name :</label>
						    <div class="col-sm-9">
						      <select class="form-control" id="editCategoryName" name="editCategoryName">
						      	<option value="">~~SELECT~~</option>
						      	<?php
						      	$sql = "SELECT categories_id, categories_name FROM category WHERE categories_status = 1 AND categories_active = 1";
						      	$result = $connect->query($sql);

						      	while ($row = $result->fetch_array()) {
						      		echo "<option value='".$row[0]."'>".$row[1]."</option>";
						      	}
						      	?>
						      </select>
						    </div>
						  </div>

						  <div class="form-group">
						    <label for="editProductStatus" class="col-sm-3 control-label">Status :</label>
						    <div class="col-sm-9">
						      <select class="form-control" id="editProductStatus" name="editProductStatus">
						      	<option value="">~~SELECT~~</option>
						      	<option value="1">Available</option>
						      	<option value="2">Not Available</option>
						      </select>
						    </div>
						  </div>

						  <div class="modal-footer editProductFooter">
						  	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      					<button type="submit" class="btn btn-primary">Save changes</button>
						  </div>

						</form>
			    </div>
			    <!-- /product Info -->
			  </div>
			</div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="removeProductModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background: url(../stock_system/custom/css/bg-image3.jpg) center fixed no-repeat;background-size: cover;color: white;border-radius: 5px 5px 0 0;">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="glyphicon glyphicon-trash"></i>&nbsp;&nbsp;Remove Product</h4>
      </div>
      <div class="modal-body">
        <p>Do you really want to remove ?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="glyphicon glyphicon-remove-sign"></i>&nbsp;&nbsp;No</button>
        <button type="button" class="btn btn-primary" id="removeProductBtn"><i class="glyphicon glyphicon-ok-sign"></i>&nbsp;&nbsp;Confirm</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="showHelpModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background: url(../stock_system/custom/css/bg-image3.jpg) center fixed no-repeat;background-size: cover;color: white;border-radius: 5px 5px 0 0;">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="glyphicon glyphicon-info-sign"></i>&nbsp;&nbsp;Help</h4>
      </div>
      <div class="modal-body">
        
      	<div class="helpWhat">
	      	<h4>What is this?</h4>
					  <div class="well" style="margin-bottom: 0;">
					  	<b>This is a Stock List table where user can view and manage the stocks.</b><br />
					  	User can insert new records, edit existing records, and also remove existing records which helps in creating more consistent and accurate data of records.
					  </div>
        </div>

        <hr />

        <div class="helpHow">
		     	<h4>How to...</h4>
	      	<div class="helpInfo">
	        	<a data-toggle="collapse" href="#collapseH1" aria-expanded="false" aria-controls="collapseH1">
						  <h4>How do I add a new product?<span class="pull pull-right fa fa-caret-down"></span></h4>
						</a>
						<div class="collapse" id="collapseH1">
						  <div class="well" style="margin-bottom: 0;">
						    You can add a new product by click on the <button type="button" class="btn btn-default"><i class="glyphicon glyphicon-plus-sign"></i>&nbsp;&nbsp;Add Product</button> button at the top right corner of the Stock List table.
						  </div>
						</div>
	      	</div>

	      	<div class="helpInfo">
						<a data-toggle="collapse" href="#collapseH2" aria-expanded="false" aria-controls="collapseH2">
						  <h4>How do I edit the product?<span class="pull pull-right fa fa-caret-down"></span></h4>
						</a>
						<div class="collapse" id="collapseH2">
						  <div class="well" style="margin-bottom: 0;">
						    You can edit the product by click on the <a type="button" class="btn btn-default dropdown-toggle"> Action <span class="caret"></span></a> button at the Options column of the table, then, click on the <button class="well" style="padding: 3px 20px;"><i class="glyphicon glyphicon-edit"></i>&nbsp;&nbsp;Edit&nbsp;&nbsp;</button> button.
						  </div>
						</div>
	      	</div>

	      	<div class="helpInfo">
						<a data-toggle="collapse" href="#collapseH3" aria-expanded="false" aria-controls="collapseH3">
						  <h4>How do I remove the product?<span class="pull pull-right fa fa-caret-down"></span></h4>
						</a>
						<div class="collapse" id="collapseH3">
						  <div class="well" style="margin-bottom: 0;">
						    You can remove the product by click on the <a type="button" class="btn btn-default dropdown-toggle"> Action <span class="caret"></span></a> button at the Options column of the table, then, click on the <button class="well" style="padding: 3px 20px;"><i class="glyphicon glyphicon-trash"></i>&nbsp;&nbsp;Remove&nbsp;&nbsp;</button> button.
						  </div>
						</div>
	      	</div>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script type="text/javascript" src="custom/js/product.js"></script>

<?php require_once 'includes/footer.php'; ?>