<?php 
	session_start();
	unset($_SESSION['username']);
	unset($_SESSION['firstName']);
	header("Location: index.php");
 ?>