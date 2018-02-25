<!DOCTYPE HTML>
<html>

<head>
	<title>Expense Tracker : Login</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />	
	<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
	<link href="css/bootstrap.min.css" rel='stylesheet' type='text/css' />
	<!-- Custom Theme files -->
	<link href="css/style.css" rel='stylesheet' type='text/css' />
	<link href="css/font-awesome.css" rel="stylesheet">
	<script src="js/jquery.min.js"> </script>
	<script src="js/bootstrap.min.js"> </script>
	
</head>
<body>
	<?php 

	include_once("Connection.php");

	session_start();
	
	if(isset($_SESSION["UserID"])){
		header("Location: index.php");
	}

	if (isset($_REQUEST['btnLogin'])) {
		
		echo "svd";
		$email=$_REQUEST['txtEmail'];
		$pass=$_REQUEST['txtPass'];

		$qry="select * from tbluser where Email='".$email."' and Password='".$pass."'";
		//echo $qry;
		$rs=mysqli_query($con,$qry);
		$row=mysqli_num_rows($rs);
		$doc=mysqli_fetch_assoc($rs);
		if($row==1){			
			$_SESSION["UserID"]=$doc["UserID"];
			$_SESSION["Name"]=$doc["Name"];
			header("Location: index.php");
		}else{
			echo"<script>alert('Wrong Credentials')</script>";
		}
	}

	?>
	<div class="login">
		<h1>
			<a href="index.html">Expense Tracker : Login</a>
		</h1>
		<div class="login-bottom">
			<h2>Login</h2>
			<form method="post">
				<div class="col-md-6">
					<div class="login-mail">
						<input type="text" name="txtEmail" placeholder="Email" required="">
						<i class="fa fa-envelope"></i>
					</div>
					<div class="login-mail">
						<input type="password" name="txtPass" placeholder="Password" required="">
						<i class="fa fa-lock"></i>
					</div>
				</div>
				<div class="col-md-6 login-do">
					<label class="hvr-shutter-in-horizontal login-sub">
						<input type="submit" value="login" name="btnLogin">
					</label>
					<p>Do not have an account?</p>
					<a href="Signup.php" class="hvr-shutter-in-horizontal">Signup</a>
				</div>

				<div class="clearfix"> </div>
			</form>
		</div>
	</div>
	<!---->
	<div class="copy-right">
		<p> Design by Ritesh Tailor</p>
	</div>
	<!---->
	<!--scrolling js-->
	<script src="js/jquery.nicescroll.js"></script>
	<script src="js/scripts.js"></script>
	<!--//scrolling js-->
</body>

</html>