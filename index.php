<?php 

require_once 'php_action/db_connect.php';

session_start();

if (isset($_SESSION['userId'])) {
	header('location: http://localhost/stock_system/dashboard.php');
}

$errors = array();

if($_POST) {
	$username = $_POST['username'];
	$password = $_POST['password'];

	if(empty($username) || empty($password)) {
		if ($username == "" && $password != "") {
			$errors[] = "&nbsp;&nbsp;Username is required";
		}

		if ($password == "" && $username != "") {
			$errors[] = "&nbsp;&nbsp;Password is required";
		}

		if ($username == "" && $password == "") {
			$errors[] = "&nbsp;&nbsp;Username and Password is required";
		}
	} else {
		$sql = "SELECT * FROM users WHERE username = '$username'";
		$result = $connect->query($sql);

		if ($result->num_rows == 1) {
			$password = md5($password);
			//if exists
			$mainSql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
			$mainResult = $connect->query($mainSql);

			if ($mainResult->num_rows == 1) {
				$value = $mainResult->fetch_assoc();
				$user_id = $value['user_id'];

				//set session
				$_SESSION['userId'] = $user_id;

				header('location: http://localhost/stock_system/dashboard.php');
			} else {
				$errors[] = "&nbsp;&nbsp;Incorrect username or password combination";
			}
		} else {
			$errors[] = "&nbsp;&nbsp;Username doesn't exists";
		}
	}
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Stock Management System</title>
	<!-- BootStrap -->
	<link rel="stylesheet" type="text/css" href="assets/bootstrap/css/bootstrap.min.css">
	<!-- BootStrap Theme -->
	<link rel="stylesheet" type="text/css" href="assets/bootstrap/css/bootstrap-theme.min.css">
	<!-- Font Awesome -->
	<link rel="stylesheet" type="text/css" href="assets/font-awesome/css/font-awesome.min.css">
	<!-- Custom CSS -->
	<link rel="stylesheet" type="text/css" href="custom/css/custom.css">
	<!-- jQuery -->
	<script type="text/javascript" src="assets/jquery/jquery-3.2.1.min.js"></script>
	<!-- jQuery ui -->
	<link rel="stylesheet" type="text/css" href="assets/jquery-ui/jquery-ui.min.css">
	<script type="text/javascript" src="assets/jquery-ui/jquery-ui.min.js"></script>
	<!-- BootStrap js -->
	<script type="text/javascript" src="assets/bootstrap/js/bootstrap.min.js"></script>
	<!-- Website Favicon -->
	<link rel="icon" type="image/png" href="includes/favicon.png">

</head>
<body style="padding-top: 5px;">

	<div class="container content-container">
		<div class="row vertical">
			<div class="col-md-6 col-md-offset-3" style="padding: 80px;">
				<div class="l-content">
					<div class="l-header">
						<h1><center><img src="includes/favicon.png" height="50px" width="50px">&nbsp;&nbsp;LOGIN</center></h1>
					</div>
					<div class="panel-body" style="padding: 30px;border-top: 1px solid black;box-shadow: inset 0px 0.5px 5px white;border-radius: 0 0 10px 10px;">
						<div class="message">
							<?php 
							if ($errors) { 
								foreach ($errors as $key => $value) {
									echo '<div class="alert alert-danger" role="alert">
							  		  	<i class="glyphicon glyphicon-exclamation-sign"></i>'. $value .'
							  		  	</div>';
								}
							} 
							?>
						</div>
						<form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
					  	<div class="form-group">
					    	<div class="col-sm-12">
				      		<input type="text" class="form-control" id="username" name="username" placeholder="Username" autocomplete="off" onfocus="this.placeholder='';" onblur="this.placeholder='Username';">
					    	</div>
					  	</div>
					  	<div class="form-group">
					    	<div class="col-sm-12">
				      		<input type="password" class="form-control" id="password" name="password" placeholder="Password" onfocus="this.placeholder='';" onblur="this.placeholder='Password';">
					    	</div>
					  	</div>
					  	<div class="form-group">
					    	<div class="col-sm-12">
				      		<button type="submit" class="btn btn-primary" style="width: 100%;height: 50px;font-size: 18px"><i class="glyphicon glyphicon-log-in"></i>&nbsp;&nbsp;Sign in</button>
					    	</div>
					  	</div>
						</form>
					</div>
				</div>
			</div><!-- col-md-5 -->
		</div><!-- /row -->
	</div><!-- /container -->
	<div class="bottom-fixed">
		<div class="outer-border"></div>
		<div class="middle-border"></div>
		<div class="inner-border"></div>
	</div>
</body>
<script type="text/javascript" src="custom/js/login.js"></script>
</html>