<?php require_once 'includes/header.php'; ?>
<div class="row">
	<div class="col-md-12">
		<ol class="breadcrumb">
		  <li><a href="dashboard.php">Home</a></li>
		  <li class="active">Suppliers</li>
		</ol>

		<div class="panel panel-info plus">
		  <div class="panel-heading"><i class="fa fa-list"></i>&nbsp;&nbsp;Supplier List&nbsp;&nbsp;<a class="glyphicon glyphicon-question-sign" title="Help" data-toggle="modal" data-target="#showHelpModal"></a></div>
		  <div class="panel-body">

		  <div class="remove-messages"></div>

		  	<div class="div-action pull pull-right" style="padding-bottom: 20px;">
					<button class="btn btn-default" data-toggle="modal" data-target="#addSupplierModal" onclick="addSupplier()"><i class="glyphicon glyphicon-plus-sign"></i>&nbsp;&nbsp;Add Supplier</button>
				</div><!-- /div-action -->

		    <table class="table" id="manageSupplierTable" style="width: 100%">
					<thead>
						<tr>
							<th>Company Name</th>
							<th style="width: 15%">Contact Person</th>
							<th style="width: 15%">Address</th>
							<th>Contact</th>
							<th>E-mail</th>
							<th>Status</th>
							<th style="width: 15%">Options</th>
						</tr>
					</thead>
				</table>

		  </div><!-- /panel-body -->
		</div><!-- /panel panel-default -->

	</div><!-- /col-md-12 -->
</div><!-- /row -->

<div class="modal fade" tabindex="-1" role="dialog" id="addSupplierModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background: url(../stock_system/custom/css/bg-image3.jpg) center fixed no-repeat;background-size: cover;color: white;border-radius: 5px 5px 0 0;">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add Supplier</h4>
      </div>

    	<form class="form-horizontal" id="addSupplierForm" action="php_action/createSuppliers.php" method="POST">
      
	      <div class="modal-body">

	      <div class="add-supplier-messages"></div>

			  <div class="form-group">
			    <label for="supplierName" class="col-sm-3 control-label">Company :</label>
			    <div class="col-sm-9">
			      <input type="text" class="form-control" id="supplierName" name="supplierName" placeholder="Company Name" autocomplete="off">
			    </div>
			  </div>

			  <div class="form-group">
			    <label for="supplierPerson" class="col-sm-3 control-label">Contact Person :</label>
			    <div class="col-sm-9">
			      <input type="text" class="form-control" id="supplierPerson" name="supplierPerson" placeholder="Contact Person" autocomplete="off">
			    </div>
			  </div>

			  <div class="form-group">
			    <label for="supplierContact" class="col-sm-3 control-label">Contact :</label>
			    <div class="col-sm-9">
			      <input type="text" class="form-control" id="supplierContact" name="supplierContact" placeholder="Contact (Example: 012-3456789)" autocomplete="off">
			    </div>
			  </div>

			  <div class="form-group">
			    <label for="supplierStatus" class="col-sm-3 control-label">Status :</label>
			    <div class="col-sm-9">
			      <select type="text" class="form-control" id="supplierStatus" name="supplierStatus">
			      <option value="">~~SELECT~~</option>
			      <option value="1">Available</option>
			      <option value="2">Not Available</option>
				    </select>
			    </div>
			  </div>

			  <div class="form-group">
			    <label for="supplierMail" class="col-sm-3 control-label">E-mail :</label>
			    <div class="col-sm-9">
			      <input type="text" class="form-control" id="supplierMail" name="supplierMail" placeholder="E-mail (Example: example@example.com)" autocomplete="off">
			    </div>
			  </div>

			  <div class="form-group">
			    <label for="supplierAddress" class="col-sm-3 control-label">Address :</label>
			    <div class="col-sm-9">
			      <textarea class="form-control" rows="5" id="supplierAddress" name="supplierAddress" placeholder="Address..." autocomplete="off"></textarea>
			    </div>
			  </div>

	      </div>

	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	        <button type="submit" class="btn btn-primary" id="createSupplierBtn" data-loading-text="Loading...">Save changes</button>
	      </div>

			</form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="editSupplierModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background: url(../stock_system/custom/css/bg-image3.jpg) center fixed no-repeat;background-size: cover;color: white;border-radius: 5px 5px 0 0;">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-edit"></i>&nbsp;&nbsp;Edit Supplier</h4>
      </div>

    	<form class="form-horizontal" id="editSupplierForm" action="php_action/editSuppliers.php" method="POST">
      
	      <div class="modal-body">

	      <div class="edit-supplier-messages"></div>

			  <div class="form-group">
			    <label for="editSupplierName" class="col-sm-3 control-label">Company Name :</label>
			    <div class="col-sm-9">
			      <input type="text" class="form-control" id="editSupplierName" name="editSupplierName" placeholder="Company Name" autocomplete="off">
			    </div>
			  </div>

			  <div class="form-group">
			    <label for="editSupplierPerson" class="col-sm-3 control-label">Contact Person :</label>
			    <div class="col-sm-9">
			      <input type="text" class="form-control" id="editSupplierPerson" name="editSupplierPerson" placeholder="Contact Person" autocomplete="off">
			    </div>
			  </div>

			  <div class="form-group">
			    <label for="editSupplierContact" class="col-sm-3 control-label">Contact :</label>
			    <div class="col-sm-9">
			      <input type="text" class="form-control" id="editSupplierContact" name="editSupplierContact" placeholder="Contact" autocomplete="off">
			    </div>
			  </div>

			  <div class="form-group">
			    <label for="editSupplierStatus" class="col-sm-3 control-label">Status :</label>
			    <div class="col-sm-9">
			      <select type="text" class="form-control" id="editSupplierStatus" name="editSupplierStatus">
			      <option value="">~~SELECT~~</option>
			      <option value="1">Available</option>
			      <option value="2">Not Available</option>
				    </select>
			    </div>
			  </div>

			  <div class="form-group">
			    <label for="editSupplierMail" class="col-sm-3 control-label">E-mail :</label>
			    <div class="col-sm-9">
			      <input type="text" class="form-control" id="editSupplierMail" name="editSupplierMail" placeholder="E-mail" autocomplete="off">
			    </div>
			  </div>

			  <div class="form-group">
			    <label for="editSupplierAddress" class="col-sm-3 control-label">Address :</label>
			    <div class="col-sm-9">
			      <textarea class="form-control" rows="5" id="editSupplierAddress" name="editSupplierAddress" placeholder="Address" autocomplete="off"></textarea>
			    </div>
			  </div>

	      </div>

	      <div class="modal-footer editSupplierFooter">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	        <button type="submit" class="btn btn-primary">Save changes</button>
	      </div>

			</form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="removeSupplierModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background: url(../stock_system/custom/css/bg-image3.jpg) center fixed no-repeat;background-size: cover;color: white;border-radius: 5px 5px 0 0;">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="glyphicon glyphicon-trash"></i>&nbsp;&nbsp;Remove Supplier</h4>
      </div>
      <div class="modal-body">
        <p>Do you really want to remove ?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="glyphicon glyphicon-remove-sign"></i>&nbsp;&nbsp;No</button>
    		<button type="button" class="btn btn-primary" id="removeSupplierBtn" data-loading-text="Loading..."><i class="glyphicon glyphicon-ok-sign"></i>&nbsp;&nbsp;Confirm</button>
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
					  	<b>This is a Supplier List table where user can view and manage the supplier records.</b><br />
					  	User can insert new records, edit existing records, and also remove existing records.
					  </div>
        </div>

        <hr />

        <div class="helpHow">
		     	<h4>How to...</h4>
	      	<div class="helpInfo">
	        	<a data-toggle="collapse" href="#collapseH1" aria-expanded="false" aria-controls="collapseH1">
						  <h4>How do I add a new supplier?<span class="pull pull-right fa fa-caret-down"></span></h4>
						</a>
						<div class="collapse" id="collapseH1">
						  <div class="well" style="margin-bottom: 0;">
						    You can add a new supplier by click on the <button type="button" class="btn btn-default"><i class="glyphicon glyphicon-plus-sign"></i>&nbsp;&nbsp;Add Supplier</button> button at the top right corner of the Supplier List table.
						  </div>
						</div>
	      	</div>

	      	<div class="helpInfo">
						<a data-toggle="collapse" href="#collapseH2" aria-expanded="false" aria-controls="collapseH2">
						  <h4>How do I edit the supplier?<span class="pull pull-right fa fa-caret-down"></span></h4>
						</a>
						<div class="collapse" id="collapseH2">
						  <div class="well" style="margin-bottom: 0;">
						    You can edit the supplier by click on the <a type="button" class="btn btn-default dropdown-toggle"> Action <span class="caret"></span></a> button at the Options column of the table, then, click on the <button class="well" style="padding: 3px 20px;"><i class="glyphicon glyphicon-edit"></i>&nbsp;&nbsp;Edit&nbsp;&nbsp;</button> button.
						  </div>
						</div>
	      	</div>

	      	<div class="helpInfo">
						<a data-toggle="collapse" href="#collapseH3" aria-expanded="false" aria-controls="collapseH3">
						  <h4>How do I remove the supplier?<span class="pull pull-right fa fa-caret-down"></span></h4>
						</a>
						<div class="collapse" id="collapseH3">
						  <div class="well" style="margin-bottom: 0;">
						    You can remove the supplier by click on the <a type="button" class="btn btn-default dropdown-toggle"> Action <span class="caret"></span></a> button at the Options column of the table, then, click on the <button class="well" style="padding: 3px 20px;"><i class="glyphicon glyphicon-trash"></i>&nbsp;&nbsp;Remove&nbsp;&nbsp;</button> button.
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

<script type="text/javascript" src="custom/js/suppliers.js"></script>

<?php require_once 'includes/footer.php'; ?>