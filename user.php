<?php require_once 'includes/header.php'; ?>

<div class="row">
	<div class="col-md-12">
		<ol class="breadcrumb">
		  <li><a href="dashboard.php">Home</a></li>
		  <li class="active">Manage Users</li>
		</ol>

		<div class="panel panel-info plus">
		  <div class="panel-heading"><i class="glyphicon glyphicon-user"></i>&nbsp;&nbsp;User List&nbsp;&nbsp;<a class="glyphicon glyphicon-question-sign" title="Help" data-toggle="modal" data-target="#showHelpModal"></a></div>
		  <div class="panel-body">
		  	<div class="remove-messages"></div>

		  	<div class="div-action pull pull-right" style="padding-bottom: 20px;">
					<button class="btn btn-default" data-toggle="modal" data-target="#addUserModal" onclick="addUser()"><i class="glyphicon glyphicon-plus-sign"></i>&nbsp;&nbsp;Add User</button>
				</div><!-- /div-action -->

		  	<table class="display compact" id="manageUserTable" style="width: 100%">
					<thead>
						<tr>
							<th>User Level</th>
							<th>Username</th>
							<th>First Name</th>
							<th>Last Name</th>
							<th>Email</th>
							<th style="width: 15%;">Options</th>
						</tr>
					</thead>
				</table>

		  </div><!-- /panel-body -->
		</div><!-- /panel panel-default -->

	</div><!-- /col-md-12 -->
</div><!-- /row -->

<div class="modal fade" tabindex="-1" role="dialog" id="addUserModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background: url(../stock_system/custom/css/bg-image3.jpg) center fixed no-repeat;background-size: contain;color: white;border-radius: 5px 5px 0 0;">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add User</h4>
      </div>
	  	<form class="form-horizontal" id="createUserForm" action="php_action/createUsers.php" method="POST">
	      <div class="modal-body">
	      <div class="add-user-messages"></div>
	        
				  <div class="form-group">
				    <label for="userLevel" class="col-sm-3 control-label">User Level :</label>
				    <div class="col-sm-9">
				      <select class="form-control" id="userLevel" name="userLevel">
				      	<option value="">~~SELECT~~</option>
				      	<?php
				      	$sql = "SELECT user_level, user_level_name FROM users_level";
				      	$result = $connect->query($sql);
				      	while ($row = $result->fetch_array()) {
				      		echo "<option value='".$row[0]."'>".$row[1]."</option>"; 	
				      	} 
				      	?>
				      </select>
				    </div>
				  </div>

				  <div class="form-group">
				    <label for="userName" class="col-sm-3 control-label">Username :</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="userName" name="userName" placeholder="Username" autocomplete="off">
				    </div>
				  </div>

				  <div class="form-group">
				    <label for="userPass" class="col-sm-3 control-label">Password :</label>
				    <div class="col-sm-9">
				      <input type="password" class="form-control" id="userPass" name="userPass" placeholder="Password" autocomplete="off">
				    </div>
				  </div>

				  <div class="form-group">
				    <label for="firstName" class="col-sm-3 control-label">First Name :</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="firstName" name="firstName" placeholder="First Name" autocomplete="off">
				    </div>
				  </div>

				  <div class="form-group">
				    <label for="lastName" class="col-sm-3 control-label">Last Name :</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="lastName" name="lastName" placeholder="Last Name" autocomplete="off">
				    </div>
				  </div>

				  <div class="form-group">
				    <label for="eMail" class="col-sm-3 control-label">E-Mail :</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="eMail" name="eMail" placeholder="E-Mail" autocomplete="off">
				    </div>
				  </div>
	        
	      </div><!-- /modal-body -->

	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	        <button type="submit" id="createUserBtn" class="btn btn-primary">Save changes</button>
	      </div>

			</form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="editUserModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background: url(../stock_system/custom/css/bg-image3.jpg) center fixed no-repeat;background-size: contain;color: white;border-radius: 5px 5px 0 0;">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-edit"></i>&nbsp;&nbsp;Edit User</h4>
      </div>
	  	<form class="form-horizontal" id="editUserForm" action="php_action/editUsers.php" method="POST">
	      <div class="modal-body">
	      <div class="edit-user-messages"></div>
	        
				  <div class="form-group">
				    <label for="editUserLevel" class="col-sm-3 control-label">User Level :</label>
				    <div class="col-sm-9">
				      <select class="form-control" id="editUserLevel" name="editUserLevel">
				      	<option value="">~~SELECT~~</option>
				      	<?php
				      	$sql = "SELECT user_level, user_level_name FROM users_level";
				      	$result = $connect->query($sql);
				      	while ($row = $result->fetch_array()) {
				      		echo "<option value='".$row[0]."'>".$row[1]."</option>"; 	
				      	} 
				      	?>
				      </select>
				    </div>
				  </div>

				  <div class="form-group">
				    <label for="editUserName" class="col-sm-3 control-label">Username :</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="editUserName" name="editUserName" placeholder="Username" autocomplete="off">
				    </div>
				  </div>

				  <div class="form-group">
				    <label for="editFirstName" class="col-sm-3 control-label">First Name :</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="editFirstName" name="editFirstName" placeholder="First Name" autocomplete="off">
				    </div>
				  </div>

				  <div class="form-group">
				    <label for="editLastName" class="col-sm-3 control-label">Last Name :</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="editLastName" name="editLastName" placeholder="Last Name" autocomplete="off">
				    </div>
				  </div>

				  <div class="form-group">
				    <label for="editEMail" class="col-sm-3 control-label">E-Mail :</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="editEMail" name="editEMail" placeholder="E-Mail" autocomplete="off">
				    </div>
				  </div>
	        
	      </div><!-- /modal-body -->

	      <div class="modal-footer editUserFooter">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	        <button type="submit" class="btn btn-primary">Save changes</button>
	      </div>

			</form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="removeUserModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background: url(../stock_system/custom/css/bg-image3.jpg) center fixed no-repeat;background-size: contain;color: white;border-radius: 5px 5px 0 0;">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="glyphicon glyphicon-trash"></i>&nbsp;&nbsp;Remove User</h4>
      </div>
      <div class="modal-body">
      <p>Do you really want to remove ?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="glyphicon glyphicon-remove-sign"></i>&nbsp;&nbsp;Close</button>
        <button type="button" class="btn btn-primary" id="removeUserBtn" data-loading-text="Loading..."><i class="glyphicon glyphicon-ok-sign"></i>&nbsp;&nbsp;Save changes</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="showHelpModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background: url(../stock_system/custom/css/bg-image3.jpg) center fixed no-repeat;background-size: contain;color: white;border-radius: 5px 5px 0 0;">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="glyphicon glyphicon-info-sign"></i>&nbsp;&nbsp;Help</h4>
      </div>
      <div class="modal-body">

      	<div class="helpWhat">
          <h4>What is this?</h4>
            <div class="well" style="margin-bottom: 0;">
            	<b>This is User List table where Admin can manage the user of this program.</b>
            	This page can only accessible by the Admin level user. Admin can create new user account or remove existing user account in this page.
            </div>
        </div>

        <hr />

        <div class="helpHow">
          <h4>How to...</h4>
          <div class="helpInfo">
	        	<a data-toggle="collapse" href="#collapseH1" aria-expanded="false" aria-controls="collapseH1">
						  <h4>How do I add a new user?<span class="pull pull-right fa fa-caret-down"></span></h4>
						</a>
						<div class="collapse" id="collapseH1">
						  <div class="well" style="margin-bottom: 0;">
						    You can add a new user by click on the <button type="button" class="btn btn-default"><i class="glyphicon glyphicon-plus-sign"></i>&nbsp;&nbsp;Add User</button> button at the top right corner of the User List table.
						  </div>
						</div>
	      	</div>

          <div class="helpInfo">
            <a data-toggle="collapse" href="#collapseH2" aria-expanded="false" aria-controls="collapseH2">
              <h4>How do I edit the user?<span class="pull pull-right fa fa-caret-down"></span></h4>
            </a>
            <div class="collapse" id="collapseH2">
              <div class="well" style="margin-bottom: 0;">
                You can edit the user by click on the <a type="button" class="btn btn-default dropdown-toggle"> Action <span class="caret"></span></a> button at the Options column of the table, then, click on the <button class="well" style="padding: 3px 20px;"><i class="glyphicon glyphicon-edit"></i>&nbsp;&nbsp;Edit&nbsp;&nbsp;</button> button.
              </div>
            </div>
          </div>

          <div class="helpInfo">
            <a data-toggle="collapse" href="#collapseH3" aria-expanded="false" aria-controls="collapseH3">
              <h4>How do I remove the user?<span class="pull pull-right fa fa-caret-down"></span></h4>
            </a>
            <div class="collapse" id="collapseH3">
              <div class="well" style="margin-bottom: 0;">
                You can remove the user by click on the <a type="button" class="btn btn-default dropdown-toggle"> Action <span class="caret"></span></a> button at the Options column of the table, then, click on the <button class="well" style="padding: 3px 20px;"><i class="glyphicon glyphicon-trash"></i>&nbsp;&nbsp;Remove&nbsp;&nbsp;</button> button.
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

<script type="text/javascript" src="custom/js/users.js"></script>

<?php require_once 'includes/footer.php'; ?>