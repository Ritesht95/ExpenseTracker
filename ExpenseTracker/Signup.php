<!DOCTYPE HTML>
<html>
<head>
<title>Expense Tracker : Sign Up</title>
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

	if(isset($_REQUEST["status"]) && $_REQUEST["status"]=="success"){ 
		echo '<script>alert("Registered Successfully")</script>';							
	}
	if(isset($_REQUEST["status"]) && $_REQUEST["status"]=="emailalreadyregistered"){
		echo '<script>alert("Enterd email is already registered")</script>';
	}else{
		if(isset($_REQUEST["btnSubmit"])){

			$Name=$_REQUEST["txtName"];
			$Email=$_REQUEST["txtEmail"];
			$Password=$_REQUEST["txtPass"];
			$CPassword=$_REQUEST["txtCPass"];
	
			echo '<script>alert("'.$Email.'");</script>';
			$credentials=array("Email"=>$Email);
	
			$collection=$db->user;
	
			$obj=$collection->find($credentials);
	
			if($obj->count()>0){
				foreach ($obj as $doc) {
					echo $doc["Email"];
					
				}	
				header("Location: Signup.php?status=emailalreadyregistered");		
			}else{
				if($Password==$CPassword){
					$collection=$db->user;
		
					$document=array(
						"Name" => $Name,
						"Email" => $Email,
						"Password" => $Password,
						"Expense" => null,
						"IsActive" => false
					);
		
					$collection->insert($document);
					
					$err="Registred Successfully";
					header("Location: Signup.php?status=success");
				}
			}			
		}
		
	}

	?>
	<form method="post">
		<div class="login">
			<h1><a href="index.html">Expense Tracker : Sign Up </a></h1>
			<div class="login-bottom">
				<h2>Register</h2>
				<div class="col-md-6">
					<div class="login-mail">
						<input type="text" placeholder="Name" required="" name="txtName">
						<i class="fa fa-user"></i>
					</div>
					<div class="login-mail">
						<input type="text" placeholder="Email" required="" name="txtEmail">
						<i class="fa fa-envelope"></i>
					</div>
					<div class="login-mail">
						<input type="password" placeholder="Password" required="" name="txtPass">
						<i class="fa fa-lock"></i>
					</div>
					<div class="login-mail">
						<input type="password" placeholder="Repeated password" required="" name="txtCPass">
						<i class="fa fa-lock"></i>
					</div>
				</div>
				<div class="col-md-6 login-do">
					<label class="hvr-shutter-in-horizontal login-sub">
						<input type="submit" value="Submit" name="btnSubmit">
					</label>
					<p>Already register</p>
					<a href="login.php" class="hvr-shutter-in-horizontal">Login</a>
					<br>
					<label style="align-self:center;" class="alert-danger">
						
					</label>
				</div>
				<div class="clearfix"> </div>
			</div>
		</div>
	</form>
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

