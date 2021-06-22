<?php

require 'config/config.php';

if(isset($_SESSION['username'])){
	$userloggedin=$_SESSION['username'];
	$user_info=mysqli_query($con,"SELECT * FROM users WHERE username='$userloggedin'");
	$user=mysqli_fetch_array($user_info);
}
	else
	{
		header("Location:register.php");
	}

?>


<!DOCTYPE html>
<html style="background-color: #484848;">
<head>
	<title>SOFTALK</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
	<script src="assets/js/bootstrap.js"></script>
	<script src="https://kit.fontawesome.com/693155309c.js" crossorigin="anonymous"></script>
	<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="assets/css/header.css">
</head>
<body>
	<div class="top_bar">
		<div class="logo">
			<a href="index.php">SOFTALK</a>
			
		</div>

		<nav>
			<a href="<?php echo $user['username']; ?>">
				
				<?php echo $user['first_name']; ?>
			</a>
			<a href="#"><i class="fas fa-home"></i></a>
			<a href="#"><i class="fas fa-comment"></i></a>
			<a href="#"><i class="fab fa-snapchat"></i></a>
			<a href="logout.php"><i class="fas fa-sign-out-alt"></i></a>
		</nav>
		
	</div>
	<div class="wrapper">
	