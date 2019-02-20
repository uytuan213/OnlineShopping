<!-- Program: Online Shopping

Revision history: Tony Trieu written Feb 1, 2019 -->
<?php 
// Connect to db
include_once('db_connect.php');
session_start();
 ?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Cache-control" content="no-cache">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Log in</title>
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
	<script type="text/javascript" src="js/script.js"></script>
</head>
<body>
	<?php  
	$error_message = "";
	$check = false;
	// Check if username and password are passed
	if (isset($_POST['txtUsername']) && isset($_POST['txtPassword'])) {
		$check = true;
		$username = $_POST['txtUsername'];
		$password = $_POST['txtPassword'];
		if ($username != "" || $password != "") {

			// $sql = "SELECT * FROM tblAccount WHERE username='".$username."' AND password='".$password."'";
			// $result = mysqli_query($con, $sql);
			// if (mysqli_num_rows($result) > 0) {
			// 	$row = mysqli_fetch_assoc($result);
			// 	$_SESSION['firstName'] = $row['firstName'];
			// 	$_SESSION['username'] = $row['username'];
			// 	header('Location: index.php');
			// }
			// else{
			// 	$error_message = "Username / Password incorrect";
			// }

			//This code prevent sql injection 
			$stmt = $con->prepare("SELECT username, firstName FROM tblAccount WHERE username=? AND password=?");
			$stmt->bind_param("ss", $username, $password);
			$stmt->execute();
			//store result
			$stmt->store_result();
			//bind result to these variables
			$stmt->bind_result($uname, $fname);
			$row = $stmt->fetch();
			//If there is 1 record --> set session
			if ($stmt->num_rows == 1) {
				$_SESSION['firstName'] = $fname;
				$_SESSION['username'] = $uname;

				header('Location: index.php');
			}
			else{
				$error_message = "Username / Password incorrect";
			}
			mysqli_close($con);
		}
		else{
			$error_message = "Username and Password is required";
		}
	}
	if($check == false || $error_message != ""){

	?>
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
						<li class="active"><a href="login.php"><i class="fas fa-sign-in-alt"></i> Log in</a></li>
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
	<section id='content'>
		<div class="container">
			<h2>Log in</h2>
			<hr>
			<form id="logInForm" action="login.php" method="POST">
				<div>
					<div class="form-group">
						<input type="text" class="form-control" name="txtUsername" id="txtUsername" 
						required autofocus placeholder="Username" value="<?php if(isset($_POST["txtUsername"])) echo $username;?>"
						>
					</div>
				
					<div class="form-group">
						<input type="password" class="form-control" name="txtPassword" id="txtPassword" 
						required placeholder="Password">
					</div>	
				
					<div id="message" class="error_message text-center">
						<?php 
							if ($error_message != '') {
								echo "<i>". $error_message ."</i>";
							}
						 ?>
					</div>
				
				
					<input type="button" class="btn btn-primary" name="btnLogin" value="Log in" onclick="logInValidate();">
				</div>
			</form>
		</div>
	</section>
<?php } ?>
	<footer class="page-footer">
		<div class="container-fluid text-right sticky-bottom">
			<p>Copyright&copy; Tony Trieu 2019</p>
		</div>
	</footer>
</body>
</html>