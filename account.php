<?php 
include_once('db_connect.php');
session_start();
if (!isset($_SESSION['firstName'])) {
	header('Location: login.php');
}
else{
?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Cache-control" content="no-cache">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php echo $_SESSION['firstName'] ?> - Account information</title>
	<link href="https://fonts.googleapis.com/css?family=Indie+Flower" rel="stylesheet">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
	<link rel="shortcut icon" type="image/png" href="img/logo.ico"/>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">

	<!-- jQuery library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

	<!-- Latest compiled JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="css/custom.css">
	<link rel="stylesheet" href="css/style-bootstrap.css">
	<!-- my js file -->
	<script type="text/javascript" src="js/script.js"></script>
</head>
<body>
	<header>
		<nav class="navbar navbar-inverse">
			<div class="container-fluid">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="nav-brand" href="index.php"><img src="img/logo.ico" id="nav-logo"></a>
				</div>
				<div class="collapse navbar-collapse" id="myNavbar">
					<ul class="nav navbar-nav">
						<li><a href="index.php"><i class="fas fa-home"></i></a></li>
						<li><a href="#">Shop</a></li>
						<li><a href="cat.php">Category</a></li>
						<li><a href="brand.php">Brands</a></li>	
					</ul>
					<ul class="nav navbar-nav navbar-right">
					<?php 
					if (!isset($_SESSION['firstName'])) {
					 ?>
						<li><a href="signup.php"><i class="fas fa-user-plus"></i></i> Sign up</a></li>
						<li><a href="login.php"><i class="fas fa-sign-in-alt"></i> Log in</a></li>
					<?php 
					}
					else{
					 ?>
					 	<li>
					 		<div class="dropdown">
							    <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">
							    	<i class="fas fa-user"></i><?php echo $_SESSION['firstName'] ?>
								    <span class="caret"></span>
								</button>
							    <ul class="dropdown-menu"> 
							      <li><a href="account.php">Account</a></li>
							      <li class="divider"></li>
							      <li><a href="logout.php">Log out</a></li>
							    </ul>
							</div>
					 	</li>
					<?php } ?>
						<li><a href="cart.php"><i class="fas fa-shopping-cart"></i></a></li>
					</ul>
				</div>		
			</div>
		</nav>
	</header>
	<section id="content">
		<div class="container">
			<?php 
			$sql = "SELECT * FROM tblAccount WHERE username='" . $_SESSION['username'] . "'";
			$result = mysqli_query($con, $sql);
			if (mysqli_num_rows($result) > 0) {
				$row = mysqli_fetch_assoc($result);
			?>
			<h1 class="text-center">Account information</h1>
			<hr>
			<form id="infoForm" action="account.php" method="POST">				
				<div class="col-md-6">
					<div class="form-group">
						<label for="txtFirstName">First name</label>
						<input type="text" class="form-control" name="txtFirstName" id="txtFirstName" 
						 value='<?php echo $row['firstName'] ?>' >
					</div>	
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="txtLastName">Last name</label>
						<input type="text" class="form-control" name="txtLastName" id="txtLastName" 
						 value='<?php echo $row['lastName'] ?>'>
					</div>	
				</div>
				<div class="col-md-12">
					<div class="form-group">
						<label for="txtDOB">Date of birth</label>
						<input type="date" class="form-control" name="txtDOB" id="txtDOB" 
						value='<?php echo $row['dateOfBirth'] ?>' >
					</div>
				</div>
				<div class="col-md-12">
					<div class="form-group">
						<label for="txtAddress">Address</label>
						<input type="text" class="form-control" name="txtAddress" id="txtAddress" 
						 value='<?php echo $row['address'] ?>' >
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label for="txtCity">City</label>
						<input type="text" class="form-control" name="txtCity" id="txtCity" 
						 value='<?php echo $row['city'] ?>' >
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label for="cbbProvince">Province</label>
						<select name="cbbProvince" id="cbbProvince" class="form-control" >
							<?php 
							// Get province from db
							$sql = "SELECT * FROM tblprovince";
							$proResult = mysqli_query($con, $sql);
							while ($province = mysqli_fetch_assoc($proResult)) {
								if ($province['provinceId'] == $row['province']) {
									echo "<option value='".$province['provinceId']."' selected>".$province['provinceName']."</option>";	
								}
								else
									echo "<option value='".$province['provinceId']."''>".$province['provinceName']."</option>";
							}
							 ?>
						</select>
					</div>	
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label for="txtPostalCode">Postal code</label>
						<input type="text" class="form-control" name="txtPostalCode" id="txtPostalCode" 
						 value='<?php echo $row['postalCode'] ?>'>
					</div>	
				</div>
				<div class="col-md-12">
					<div class="form-group">
						<label for="txtEmail">Email</label>
						<input type="email" class="form-control" name="txtEmail" id="txtEmail" 
						 value='<?php echo $row['email'] ?>' >
					</div>
				</div>
				<div class="col-md-12">
					<div id="message" class="error_message text-center">
					</div>
				</div>
				<div class="col-md-12">
					<button type="button" class="btn btn-primary" name="btnChangeInfo" onclick="changeInfoValidate();">
						Save change
					</button>
					<a href="index.php" class="btn btn-primary">Cancel</a>
					<a href="changePassword.php" class="btn btn-primary">Change Password</a>
				</div>
			</form>
			<?php 
			}
			else{
			?>
			<p>Something went wrong! Did you <a href="login.php">log in</a>?</p>
			<?php
			}
			?>	
		</div>
		
	</section>
	<footer>
		<div class="container-fluid text-right">
			<p>Copyright&copy; Tony Trieu 2019</p>	
		</div>
	</footer>
</body>
</html>
<?php }
mysqli_close($con);
 ?>