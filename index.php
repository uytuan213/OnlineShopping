<!-- Add initial DB and session -->
<?php 
	include_once('db_connect.php');
	session_start();
 ?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Cache-control" content="no-cache">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Online shopping</title>
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
							      <li><a href="changePassword.php">Change password</a></li>
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
		<!-- Thumbnail -->
		<!-- Carosel -->
		<div class="container-fluid">
			<div id="myCarousel" class="carousel slide" data-interval="3000" data-ride="carousel">
			    <!-- Carousel indicators -->
			    <ol class="carousel-indicators">
			        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
			        <li data-target="#myCarousel" data-slide-to="1"></li>
			        <li data-target="#myCarousel" data-slide-to="2"></li>
			    </ol>   
			    <!-- Carousel items -->
			    <div class="carousel-inner">
			        <div class="item active">
			            <img src="img/banner1.jpeg" alt="First Slide">
			            <div class="carousel-caption">
			                <!-- <h3>First slide label</h3>
			                <p>Lorem ipsum dolor sit amet...</p> -->
			            </div>
			        </div>
			        <div class="item">
			            <img src="img/banner4.jpeg" alt="Second Slide">
			            <div class="carousel-caption">
			                <!-- <h3>Second slide label</h3>
			                <p>Aliquam sit amet gravida nibh, facilisis...</p> -->
			            </div>
			        </div>
			        <div class="item">
			            <img src="img/banner3.jpeg" alt="Third Slide">
			            <div class="carousel-caption">
			                <!-- <h3>Third slide label</h3>
			                <p>Praesent commodo cursus magna vel...</p> -->
			            </div>
			        </div>
			    </div>
			    <!-- Carousel nav -->
			    <a class="carousel-control left" href="#myCarousel" data-slide="prev">
			        <span class="glyphicon glyphicon-chevron-left"></span>
			    </a>
			    <a class="carousel-control right" href="#myCarousel" data-slide="next">
			        <span class="glyphicon glyphicon-chevron-right"></span>
			    </a>
			</div>

		<!-- Display Categories -->
		<div class="container">
		<section id="category">
			<h1 id="title" class="text-center">Category</h1>
			<hr>
			<!-- Show 4 categories here by PHP -->
			<div class="container">
				<div class="row text-center">
					<?php 
					$max_display = 4;
					$sql = "SELECT * FROM tblCategory LIMIT " . $max_display;
					$result = mysqli_query($con, $sql);
					$max_column = 4;
					$cur_column = 0;
					while ($row = mysqli_fetch_assoc($result)) { 
						?>
					<div class="col-md-3">
						<a href="#">
							<img class="logo" src="<?php echo $row['image']?>">
							<h3><?php echo $row['catName'] ?></h3>
						</a>
					</div>
					<?php } ?>	
				</div>
				<div class="text-right"><a href="cat.php">See more</a></div>
			</div>
		</section>

		<!-- Display brands -->
		<section id="brands">
			<h1 id="title" class="text-center">Brands</h1>
			<hr>
			<!-- Show 4 categories here by PHP -->
			<div class="container">
				<div class="row text-center">
					<?php 
					$sql = "SELECT * FROM tblbrand LIMIT " . $max_display;
					$result = mysqli_query($con, $sql);
					while ($row = mysqli_fetch_assoc($result)) { 
						?>
					<div class="col-md-3">
						<a href="#">
							<img class="logo" src="<?php echo $row['image']?>">
							<h3><?php echo $row['brandName'] ?></h3>
						</a>
					</div>
					<?php } ?>
				</div>
			</div>
			<div class="text-right">
				<a href="brand.php">See more</a>
			</div>
		</section>


		<section id="info">
			<h1 id="title">About me</h1>
			<hr>
				<div>
					<h3>Tony Uy-Tuan Trieu</h3>
					<h3>Computer Programmer / Analyst</h3>
					<h3>Conestoga College, Kitchener, Ontario</h3>
				</div>
			<hr>
		</section>
		</div>
	</section>
	<footer>
		<div class="container-fluid text-right">
			<p>Copyright&copy; Tony Trieu 2019</p>
		</div>
	</footer>
	<?php mysqli_close($con); ?>
</body>
</html>