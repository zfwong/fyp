<?php require_once 'includes/header.php'; ?>

<div class="row">
	<div class="col-md-12">
		<ol class="breadcrumb">
      <li><a href="dashboard.php">Home</a></li>
      <li>Inventory</li>
			<li class="active">Brand</li>
		</ol>

		<div class="panel panel-info plus">
			<div class="panel-heading"><i class="glyphicon glyphicon-edit"></i>&nbsp;&nbsp;Manage Brands&nbsp;&nbsp;<a class="glyphicon glyphicon-question-sign" title="Help" data-toggle="modal" data-target="#showHelpModal"></a></div>
			<div class="panel-body">
				<div class="remove-messages"></div>

				<div class="div-action pull pull-right" style="padding-bottom: 20px;">
					<button class="btn btn-default" data-toggle="modal" data-target="#addBrandModal" onclick="addBrand()"><i class="glyphicon glyphicon-plus-sign"></i>&nbsp;&nbsp;Add Brand</button>
				</div><!-- /div-action -->

				<table class="display compact" id="manageBrandTable" style="width: 100%">
					<thead>
						<tr>
							<th>Brand Name</th>
							<th>Status</th>
							<th style="width: 15%;">Options</th>
						</tr>
					</thead>
				</table>

			</div>
		</div>

	</div><!-- /col-md-12 -->
</div><!-- /row -->

<div class="modal fade" tabindex="-1" role="dialog" id="addBrandModal">
	<div class="modal-dialog" role="document">
  	<div class="modal-content">
  		<div class="modal-header" style="background: url(../stock_system/custom/css/bg-image3.jpg) center fixed no-repeat;background-size: cover;color: white;border-radius: 5px 5px 0 0;">
    		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    		<h4 class="modal-title"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add Brand</h4>
  		</div>
			<form class="form-horizontal" id="submitBrandForm" action="php_action/createBrand.php" method="POST">
  			<div class="modal-body">

          <div id="add-brand-messages"></div>

		  		<div class="form-group">
		    		<label for="brandName" class="col-sm-3 control-label">Brand Name :</label>
		    		<div class="col-sm-9">
		      			<input type="text" class="form-control" id="brandName" name="brandName" placeholder="Brand Name" autocomplete="off">
		    		</div>
		  		</div>

		  		<div class="form-group">
		    		<label for="brandStatus" class="col-sm-3 control-label">Status :</label>
		    		<div class="col-sm-9">
				    	<select class="form-control" id="brandStatus" name="brandStatus">
				    		<option value="">~~SELECT~~</option>
				    		<option value="1">Available</option>
				    		<option value="2">Not Available</option>
				    	</select>
		   			</div>
		  		</div>

    		</div>

    		<div class="modal-footer">
      		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      		<button type="submit" class="btn btn-primary" id="createBrandBtn" data-loading-text="Loading...">Save changes</button>
    		</div>

  		</form>
  	</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="editBrandModal">
	<div class="modal-dialog" role="document">
  	<div class="modal-content">
    		<div class="modal-header" style="background: url(../stock_system/custom/css/bg-image3.jpg) center fixed no-repeat;background-size: cover;color: white;border-radius: 5px 5px 0 0;">
      		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      		<h4 class="modal-title"><i class="fa fa-edit"></i>&nbsp;&nbsp;Edit Brand</h4>
    		</div>

    		<form class="form-horizontal" id="editBrandForm" action="php_action/editBrand.php" method="POST">
			    <div class="modal-body">

            <div id="edit-brand-messages"></div>

      			<div class="form-group">
			    		<label for="editBrandName" class="col-sm-3 control-label">Brand Name :</label>
			    		<div class="col-sm-9">
			      			<input type="text" class="form-control" id="editBrandName" name="editBrandName" placeholder="Brand Name" autocomplete="off">
			    		</div>
			  		</div>

			  		<div class="form-group">
			    		<label for="editBrandStatus" class="col-sm-3 control-label">Status :</label>
			    		<div class="col-sm-9">
					    	<select class="form-control" id="editBrandStatus" name="editBrandStatus">
					    		<option value="">~~SELECT~~</option>
					    		<option value="1">Available</option>
					    		<option value="2">Not Available</option>
					    	</select>
			   			</div>
			  		</div>
      		</div>
    		<div class="modal-footer editBrandFooter">
      		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      		<button type="submit" class="btn btn-primary">Save changes</button>
    		</div>

    		</form>
  	</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="removeBrandModal">
	<div class="modal-dialog" role="document">
  	<div class="modal-content">
    		<div class="modal-header" style="background: url(../stock_system/custom/css/bg-image3.jpg) center fixed no-repeat;background-size: cover;color: white;border-radius: 5px 5px 0 0;">
      		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      		<h4 class="modal-title"><i class="glyphicon glyphicon-trash"></i>&nbsp;&nbsp;Remove Brand</h4>
    		</div>
    		<div class="modal-body">
      		<p>Do you really want to remove ?</p>
    		</div>
    		<div class="modal-footer">
      		<button type="button" class="btn btn-default" data-dismiss="modal"><i class="glyphicon glyphicon-remove-sign"></i>&nbsp;&nbsp;No</button>
      		<button type="button" class="btn btn-primary" id="removeBrandBtn" data-loading-text="Loading..."><i class="glyphicon glyphicon-ok-sign"></i>&nbsp;&nbsp;Confirm</button>
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
					  	<b>This is a Manage Brands table where user can view and manage the brand records.</b><br />
					  	User can insert new records, edit existing records, and also remove existing records.
					  </div>
        </div>

        <hr />

        <div class="helpHow">
		     	<h4>How to...</h4>
	      	<div class="helpInfo">
	        	<a data-toggle="collapse" href="#collapseH1" aria-expanded="false" aria-controls="collapseH1">
						  <h4>How do I add a new brand?<span class="pull pull-right fa fa-caret-down"></span></h4>
						</a>
						<div class="collapse" id="collapseH1">
						  <div class="well" style="margin-bottom: 0;">
						    You can add a new brand by click on the <button type="button" class="btn btn-default"><i class="glyphicon glyphicon-plus-sign"></i>&nbsp;&nbsp;Add Brand</button> button at the top right corner of the Manage Brands table.
						  </div>
						</div>
	      	</div>

	      	<div class="helpInfo">
						<a data-toggle="collapse" href="#collapseH2" aria-expanded="false" aria-controls="collapseH2">
						  <h4>How do I edit the brand?<span class="pull pull-right fa fa-caret-down"></span></h4>
						</a>
						<div class="collapse" id="collapseH2">
						  <div class="well" style="margin-bottom: 0;">
						    You can edit the brand by click on the <a type="button" class="btn btn-default dropdown-toggle"> Action <span class="caret"></span></a> button at the Options column of the table, then, click on the <button class="well" style="padding: 3px 20px;"><i class="glyphicon glyphicon-edit"></i>&nbsp;&nbsp;Edit&nbsp;&nbsp;</button> button.
						  </div>
						</div>
	      	</div>

	      	<div class="helpInfo">
						<a data-toggle="collapse" href="#collapseH3" aria-expanded="false" aria-controls="collapseH3">
						  <h4>How do I remove the brand?<span class="pull pull-right fa fa-caret-down"></span></h4>
						</a>
						<div class="collapse" id="collapseH3">
						  <div class="well" style="margin-bottom: 0;">
						    You can remove the brand by click on the <a type="button" class="btn btn-default dropdown-toggle"> Action <span class="caret"></span></a> button at the Options column of the table, then, click on the <button class="well" style="padding: 3px 20px;"><i class="glyphicon glyphicon-trash"></i>&nbsp;&nbsp;Remove&nbsp;&nbsp;</button> button.
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

<script type="text/javascript" src="custom/js/brand.js"></script>

<?php require_once 'includes/footer.php'; ?>