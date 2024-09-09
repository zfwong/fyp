<?php require_once 'includes/header.php'; ?>

<?php 
$user_id = $_SESSION['userId'];
$sql = "SELECT * FROM users WHERE user_id = {$user_id}";
$query = $connect->query($sql);
$result = $query->fetch_assoc();

$connect->close();
?>

<div class="row">
	<div class="col-md-12">


		<ol class="breadcrumb">
		  <li><a href="dashboard.php">Home</a></li>
		  <li class="active">Setting</li>
		</ol>
		<div class="panel panel-info plus">
		  <div class="panel-heading"><i class="glyphicon glyphicon-wrench"></i>&nbsp;&nbsp;Setting&nbsp;&nbsp;<a class="glyphicon glyphicon-question-sign" title="Help" data-toggle="modal" data-target="#showHelpModal"></a></div>
		  <div class="panel-body">

		  	<form class="form-horizontal" id="changeUsernameForm" action="php_action/changeUsername.php" method="POST">
			  	<fieldset>
				  	<legend><i class="glyphicon glyphicon-pencil"></i>&nbsp;&nbsp;Change Username</legend>
				  	<div id="changeUsernameMessage"></div>

					  <div class="form-group">
					    <label for="settingUsername" class="col-sm-2 control-label">Username</label>
					    <div class="col-sm-10">
					      <input type="text" class="form-control" id="settingUsername" name="settingUsername" placeholder="Username" value="<?php echo $result['username']; ?>" autocomplete="off">
					    </div>
					  </div>

					  <div class="form-group">
					  	<div class="col-sm-offset-2 col-sm-10">
					  		<input type="hidden" name="user_id" id="user_id" value="<?php echo $result['user_id']; ?>">
	  		        <button type="submit" class="btn btn-success" data-loading-text="Loading..." id="changeUsernameBtn"><i class="glyphicon glyphicon-ok-sign"></i>&nbsp;&nbsp;Save changes</button>
					  	</div>
					  </div>

			  	</fieldset>
				</form>
				<br />

				<form class="form-horizontal" id="changePasswordForm" action="php_action/changePassword.php" method="POST">
			  	<fieldset>
				  	<legend><i class="glyphicon glyphicon-pencil"></i>&nbsp;&nbsp;Change Password</legend>
				  	<div id="changePasswordMessage"></div>

					  <div class="form-group">
					    <label for="currentPassword" class="col-sm-2 control-label">Current Password</label>
					    <div class="col-sm-10">
					      <input type="password" class="form-control" id="currentPassword" name="currentPassword" placeholder="Current Password" autocomplete="off">
					    </div>
					  </div>

					  <div class="form-group">
					    <label for="newPassword" class="col-sm-2 control-label">New Password</label>
					    <div class="col-sm-10">
					      <input type="password" class="form-control" id="newPassword" name="newPassword" placeholder="New Password" autocomplete="off">
					    </div>
					  </div>

					  <div class="form-group">
					    <label for="confirmPassword" class="col-sm-2 control-label">Confirm Password</label>
					    <div class="col-sm-10">
					      <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Confirm Password" autocomplete="off">
					    </div>
					  </div>

					  <div class="form-group">
					  	<div class="col-sm-offset-2 col-sm-10">
					  			<input type="hidden" name="user_id" id="user_id" value="<?php echo $result['user_id']; ?>">
		  		        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#confirmChangesModal"><i class="glyphicon glyphicon-ok-sign"></i>&nbsp;&nbsp;Save changes</button>
					  	</div>
					  </div>

						<!-- Confirmation Modal -->
						<div class="modal fade" id="confirmChangesModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
						  <div class="modal-dialog" role="document">
						    <div class="modal-content">
						      <div class="modal-header" style="background: url(../stock_system/custom/css/bg-image3.jpg) center fixed no-repeat;background-size: cover;color: white;border-radius: 5px 5px 0 0;">
						        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						        <h4 class="modal-title" id="myModalLabel"><i class="glyphicon glyphicon-check"></i> Confirmation</h4>
						      </div>
						      <div class="modal-body">
						        <p>Do you really want to change ?</p>
						      </div>
						      <div class="modal-footer">
						        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						        <button type="submit" class="btn btn-primary">Save changes</button>
						      </div>
						    </div>
						  </div>
						</div>
						<!-- /Confirmation Modal -->

			  	</fieldset>
				</form>

		  </div><!-- /panel-body -->
		</div><!-- /panel -->

	</div><!-- /col-md-12 -->
</div><!-- /row -->

<div class="modal fade" tabindex="-1" role="dialog" id="showHelpModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background: url(../stock_system/custom/css/bg-image3.jpg) center fixed no-repeat;background-size: cover;color: white;border-radius: 5px 5px 0 0;">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="glyphicon glyphicon-info-sign"></i>&nbsp;&nbsp;Help</h4>
      </div>
      <div class="modal-body">

      	<div class="helpWhat">
          <h4>What is this ?</h4>
          <div class="well" style="margin-bottom: 0;">
	          <b>This is Setting page which allow user to change username and password.</b><br />
	          User are required to type their current password in order to change the password with a new one.
          </div>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script type="text/javascript" src="custom/js/setting.js"></script>

<?php require_once 'includes/footer.php';  ?>