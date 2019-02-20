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
						<li class="active"><a href="index.php"><i class="fas fa-home"></i></a></li>
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
			$error_message = "";
			$checkSuccess = true;
			if (isset($_POST["txtOldPassword"])
				&& isset($_POST["txtNewPassword"])
				&& isset($_POST["txtConfirmPassword"])) {
				$username = $_POST["txtUsername"];
				$oldPwd = $_POST["txtOldPassword"];
				$newPwd = $_POST["txtNewPassword"];
				$conPwd = $_POST["txtConfirmPassword"];
				$sql = "SELECT * FROM tblAccount WHERE username='".$username."' AND password='".$oldPwd."'";
				$result = mysqli_query($con, $sql); 
				if (mysqli_num_rows($result) > 0) {
					if ($newPwd == $conPwd) {
						//$sql = "UPDATE tblAccount SET password='" . $newPwd ."' WHERE username='".$username."'";
						$stmt = $con->prepare("UPDATE tblAccount SET password=? WHERE username=?;");
						$stmt->bind_param("ss", $newPwd, $username);
						if($stmt->execute()){
							echo "Your password has been changed!";			
						}else{
							$error_message="Something went wrong, please try again later!";
						}
					}
					else{
						$error_message = "Confirm password does not match";
						$checkSuccess = false;
					}
				}
				else{
					$error_message = "Old password is not correct";
					$checkSuccess = false;
				}
			}
			if (!$checkSuccess || $error_message != "" 
				|| !isset($_POST["txtOldPassword"])) {
				$sql = "SELECT * FROM tblAccount WHERE username='" . $_SESSION['username'] . "'";
				$result = mysqli_query($con, $sql);
				if (mysqli_num_rows($result) > 0) {
					$row = mysqli_fetch_assoc($result);
				?>
				<h1 class="text-center">Change password</h1>
				<hr>
				<form id="changePasswordForm" action="changePassword.php" method="POST">
					<div class="col-md-12">
						<div class="form-group">
							<input type="hidden" class="form-control" name="txtUsername" id="txtUsername" 
							 value="<?php echo $row['username']?>">
						</div>	
					</div>
					<div class="col-md-12">
						<div class="form-group">
							<label for="txtOldPassword">Old Password</label>
							<input type="password" class="form-control" name="txtOldPassword" id="txtOldPassword" 
							 placeholder="Old Password">
						</div>	
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="txtNewPassword">New Password</label>
							<input type="password" class="form-control" name="txtNewPassword" id="txtNewPassword" 
							 placeholder="New Password">
						</div>	
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="txtConfirmPassword">Confirm Password</label>
							<input type="password" class="form-control" name="txtConfirmPassword" id="txtConfirmPassword" 
							 placeholder="Confirm Password">
						</div>	
					</div>
					<div class="col-md-12">
						<div id="message" class="error_message text-center">
							<?php 
								if($error_message != ""){
									echo $error_message;
								}
							?>
						</div>
					</div>
					<div class="col-md-12">
						<button type="button" class="btn btn-primary" name="btnChangePassword" onclick="changePasswordValidate();">
							Change password
						</button>
					</div>
				</form>
				<?php 
				}
				else{
				?>
				<p>Something went wrong! Did you <a href="login.php">log in</a>?</p>
				<?php
				}
				mysqli_close($con);
			}}
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