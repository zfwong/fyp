<?php require_once 'php_action/core.php'; ?>

<?php 
$user_id = $_SESSION['userId'];
$sql = "SELECT * FROM users WHERE user_id = $user_id";
$result = $connect->query($sql);
$result = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
	<title>Stock Management System</title>

	<!-- BootStrap min CSS -->
	<link rel="stylesheet" type="text/css" href="assets/bootstrap/css/bootstrap.min.css">
	<!-- BootStrap Theme min CSS -->
	<link rel="stylesheet" type="text/css" href="assets/bootstrap/css/bootstrap-theme.min.css">
	<!-- Font Awesome min CSS -->
	<link rel="stylesheet" type="text/css" href="assets/font-awesome/css/font-awesome.min.css">
	<!-- Custom CSS -->
	<link rel="stylesheet" type="text/css" href="custom/css/custom.css">
	<!-- DataTables min CSS-->
	<link rel="stylesheet" type="text/css" href="assets/plugins/datatables/datatables.min.css">
	<!-- FileInput min CSS -->
	<link rel="stylesheet" type="text/css" href="assets/plugins/fileinput/css/fileinput.min.css">
	<!-- jQuery min js -->
	<script type="text/javascript" src="assets/jquery/jquery-3.2.1.min.js"></script>
	<!-- jQuery ui min CSS js -->
	<link rel="stylesheet" type="text/css" href="assets/jquery-ui/jquery-ui.min.css">
	<script type="text/javascript" src="assets/jquery-ui/jquery-ui.min.js"></script>
	<!-- Moment js -->
	<script type="text/javascript" src="assets/plugins/moment/moment.min.js"></script>
	<!-- BootStrap js -->
	<script type="text/javascript" src="assets/bootstrap/js/transition.js"></script>
	<script type="text/javascript" src="assets/bootstrap/js/collapse.js"></script>
	<script type="text/javascript" src="assets/bootstrap/js/bootstrap.min.js"></script>	
	<!-- BootStrap-DateTimePicker CSS js -->
	<link rel="stylesheet" type="text/css" href="assets/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css">
	<script type="text/javascript" src="assets/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
	<!-- Website Favicon -->
	<link rel="icon" type="image/png" href="includes/favicon.png">
	
</head>
<body>

	<nav class="navbar navbar-default navbar-fixed-top">
		<div class="container">
			<!-- Brand and toggle get grouped for better mobile display -->
    		<div class="navbar-header">
    			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
      			<span class="sr-only">Toggle navigation</span>
      			<span class="icon-bar"></span>
      			<span class="icon-bar"></span>
      			<span class="icon-bar"></span>
    			</button>
    				<a href="dashboard.php" class="navbar-brand">
			        <span class="logo">
			        	<img alt="Brand" src="includes/favicon.png">Zen Corner's Inventory Management System
			        </span>
			      </a>
      		</div>

			<!-- Collect the nav links, forms, and other content for toggling -->
	    	<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
	      		<ul class="nav navbar-nav navbar-right">

	      			<li id="navDashboard"><a href="dashboard.php"><i class="glyphicon glyphicon-list-alt"></i>&nbsp;&nbsp;Dashboard</a></li>

	        		<li id="navSuppliers"><a href="suppliers.php"><i class="fa fa-address-book"></i>&nbsp;&nbsp;Suppliers</a></li>

	      			<li class="dropdown" id="navBrCa">
          			<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="glyphicon glyphicon-home"></i>&nbsp;&nbsp;Inventory&nbsp;&nbsp;<span class="caret"></span></a>
          			<ul class="dropdown-menu">
			        		<li id="navBrand"><a href="brand.php"><i class="fa fa-bold"></i>&nbsp;&nbsp;Brand</a></li>
			        		<li id="navCategories"><a href="categories.php"><i class="glyphicon glyphicon-th-list"></i>&nbsp;&nbsp;Category</a></li>
			        		<li id="navProduct"><a href="product.php"><i class="fa fa-archive"></i>&nbsp;&nbsp;Stock</a></li>
          			</ul>
	        		</li>

	        		<li class="dropdown" id="navOrder">
          			<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-truck"></i>&nbsp;&nbsp;Orders&nbsp;&nbsp;<span class="caret"></span></a>
          			<ul class="dropdown-menu">
            			<li id="topNavManageOrder"><a href="orders.php?o=manord"><i class="glyphicon glyphicon-edit"></i>&nbsp;&nbsp;Manage Orders</a></li>
            			<li id="topNavAddOrder"><a href="orders.php?o=add"><i class="glyphicon glyphicon-plus"></i>&nbsp;&nbsp;Add Orders</a></li>
          			</ul>
	        		</li>

	        		<li id="navReport"><a href="report.php"><i class="fa fa-bar-chart"></i>&nbsp;&nbsp;Report</a></li>

	        		<li class="dropdown" id="navUser">
          			<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="glyphicon glyphicon-user"></i>&nbsp;<?php echo $result['username']; ?>&nbsp;<span class="caret"></span></a>
          			<ul class="dropdown-menu">
            			<li id="topNavSetting"><a href="setting.php"><i class="glyphicon glyphicon-wrench"></i>&nbsp;&nbsp;Setting</a></li>
            			<?php if ($result['user_level'] == 1) { ?>
									<li id="topNavManageUsers"><a href="user.php"><i class="fa fa-user-plus"></i>&nbsp;&nbsp;Manage Users</a></li>
            			<?php } ?>
            			<li id="topNavLogout"><a href="logout.php"><i class="glyphicon glyphicon-log-out"></i>&nbsp;&nbsp;Logout</a></li>
          			</ul>
	        		</li>

	      		</ul>

	    	</div><!-- /.navbar-collapse -->
  		</div><!-- /.container-fluid -->
		</nav>

	<div class="container content-container">