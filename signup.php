<?php 
include_once('db_connect.php');
session_start();
 ?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Cache-control" content="no-cache">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Create an account</title>
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
						<li class="active"><a href="signup.php"><i class="fas fa-user-plus"></i></i> Sign up</a></li>
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
							      <li><a href="#">Sign out</a></li>
							    </ul>
							</div>
					 	</li>
						<li><a href="cart.php"><i class="fas fa-shopping-cart"></i></a></li>
					<?php } ?>
					</ul>
				</div>		
			</div>
		</nav>
	</header>
	<section id="content">
		<div class="container">
		<!-- PHP code to validate in server side -->
		<?php 
		$error_message = "";
		$check = false; //variable to check if all input is passed
		if (isset($_POST["txtUsername"]) && isset($_POST["txtPassword"])
			&& isset($_POST["txtFirstName"]) && isset($_POST["txtLastName"])) {
			$check = true;
			$username = $_POST["txtUsername"];
			$password = $_POST["txtPassword"];
			$confirmPassword = $_POST["txtConfirmPassword"];
			$firstName = $_POST["txtFirstName"];
			$lastName = $_POST["txtLastName"];
			$dob = $_POST["txtDOB"];
			$address = $_POST["txtAddress"];
			$postalCode = $_POST["txtPostalCode"];
			$city = $_POST["txtCity"];
			$province = $_POST["cbbProvince"];
			$email = $_POST["txtEmail"];
			if ($username == "") {
				 $error_message .= "Username is required<br>" ;
			}
			else{
				$sql = "SELECT * FROM tblAccount WHERE username = '" . $username . "'";
				$result = mysqli_query($con, $sql);
				$count = mysqli_num_rows($result);
				if($count > 0){
					$error_message .= "Username already used<br>" ;	
				}
			}
			if ($password == "") {
				$error_message .= "Password is required<br>" ;
			}
			if ($password != $confirmPassword) {
				$error_message .= "Confirm password does not match<br>" ;
			}
			if ($dob > getdate()) {
				$error_message .= "Date of birth cannot be in future<br>";
			}
			$pcRegex = '/^([a-zA-Z]\d[a-zA-Z])\ {0,1}(\d[a-zA-Z]\d)$/';
			if (!preg_match($pcRegex, $postalCode)) {
				$error_message .= "Postal code is invalid<br>";
			}
			if ($email != "" && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
				$error_message .= "Email is invalid<br>";
			}
		}
		if ($error_message == "" && $check) {
			//Add to database
			// $sql = $con->prepare("INSERT INTO tblaccount (username, password, firstName, lastName, dateOfBirth, address, postalCode, city, province, email) VALUES ?,?,?,?,?,?,?,?,?,?");
			// $sql->bind_param('ssssssssis', $username, $password, $firstName, $lastName, $dob, $address, $postalCode, $city, $province, $email);
			// if ($sql->execute()) {
			// 	echo "Congratulation! You now are a member of Tech House";
			// }
			// else{
			// 	echo "Something went wrong! Please try again later :(";
			// }

			if ($con === false) {
				echo "Cannot connect to db";
				die("ERROR: Could not connect. " . mysqli_connect_error());
			}
			$sql = "INSERT INTO tblAccount (username, password, firstName, lastName, dateOfBirth, address, postalCode, city, province, email) VALUES ('".$username."','".$password."','".$firstName."','".$lastName."','".$dob."','".$address."','".$postalCode."','".$city."','".$province."','".$email."')";
			$temp = mysqli_query($con, $sql);
			if ($temp === false) {
				echo mysqli_error($con);
			}
			else{ 
				$_SESSION["firstName"] = $firstName;
				$_SESSION["username"] = $username;
			?>
				<div>
					<p>Thank you <?php echo $_SESSION["firstName"] ?> for being our member!</p>
					<a href="index.php">Click here to continue shopping</a>
				</div>
			<?php  
			}
		}
		else{
		?>

		<h1 id="text-center">Create an account</h1>
		<hr>
		<form id="signUpForm" action="signup.php" method="POST">
			<div class="col-md-12">
				<div class="form-group">
					<label for="txtUsername">Username</label>
					<input type="text" class="form-control" name="txtUsername" id="txtUsername" 
					required autofocus placeholder="Username">
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="txtPassword">Password</label>
					<input type="password" class="form-control" name="txtPassword" id="txtPassword" 
					required placeholder="Password">
				</div>	
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="txtConfirmPassword">Confirm Password</label>
					<input type="password" class="form-control" name="txtConfirmPassword" id="txtConfirmPassword" 
					required placeholder="Confirm Password">
				</div>	
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="txtFirstName">First name</label>
					<input type="text" class="form-control" name="txtFirstName" id="txtFirstName" 
					required placeholder="First name">
				</div>	
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="txtLastName">Last name</label>
					<input type="text" class="form-control" name="txtLastName" id="txtLastName" 
					required placeholder="Last name">
				</div>	
			</div>
			<div class="col-md-12">
				<div class="form-group">
					<label for="txtDOB">Date of birth</label>
					<input type="date" class="form-control" name="txtDOB" id="txtDOB" 
					required >
				</div>
			</div>
			<div class="col-md-12">
				<div class="form-group">
					<label for="txtAddress">Address</label>
					<input type="text" class="form-control" name="txtAddress" id="txtAddress" 
					required placeholder="Address">
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label for="txtCity">City</label>
					<input type="text" class="form-control" name="txtCity" id="txtCity" 
					required placeholder="City">
				</div>	
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label for="cbbProvince">Province</label>
					<select name="cbbProvince" id="cbbProvince" class="form-control">
						<?php 
						// Get province from db
						$sql = "SELECT * FROM tblprovince";
						$result = mysqli_query($con, $sql);
						while ($row = mysqli_fetch_assoc($result)) {
							echo "<option value='".$row['provinceId']."''>".$row['provinceName']."</option>";
						}
						 ?>
					</select>
				</div>	
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label for="txtPostalCode">Postal code</label>
					<input type="text" class="form-control" name="txtPostalCode" id="txtPostalCode" 
					required placeholder="Postal code">
				</div>	
			</div>
			<div class="col-md-12">
				<div class="form-group">
					<label for="txtEmail">Email</label>
					<input type="email" class="form-control" name="txtEmail" id="txtEmail" 
					required placeholder="Email">
				</div>
			</div>
			<div class="col-md-12">
				<div id="message" class="error_message text-center">
				</div>
			</div>
			<div class="col-md-12">
				<input type="button" class="btn btn-primary" name="btnSubmit" value="Create an account" onclick="signUpValidate();">
			</div>
		</form>
		<hr>
		<?php }?>
		</div>
	</section>
	<footer>
		<div class="container-fluid text-right">
			<p>Copyright&copy; Tony Trieu 2019</p>
		</div>
	</footer>
</body>
</html>