<!DOCTYPE HTML>
<html>

<head>
    <title>Expense Tracker : Graphs</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
    <link href="css/bootstrap.min.css" rel='stylesheet' type='text/css' />
    <!-- Custom Theme files -->
    <link href="css/style.css" rel='stylesheet' type='text/css' />
    <!-- <link href="css/font-awesome.css" rel="stylesheet"> -->
    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
    <script src="js/jquery.min.js"> </script>
    <!-- Mainly scripts -->
    <script src="js/jquery.metisMenu.js"></script>
    <script src="js/jquery.slimscroll.min.js"></script>
    <!-- Custom and plugin javascript -->
    <link href="css/custom.css" rel="stylesheet">
    <script src="js/custom.js"></script>
	<script src="js/screenfull.js"></script>
	<!-- Custom Theme files -->
	<link href="css/style.css" rel='stylesheet' type='text/css' />
	<link href="css/font-awesome.css" rel="stylesheet">
	<script src="js/jquery.min.js"> </script>
	<script src="js/Chart.js"></script>
    <script>
        $(function () {
            $('#supported').text('Supported/allowed: ' + !!screenfull.enabled);

            if (!screenfull.enabled) {
                return false;
            }

            $('#toggle').click(function () {
                screenfull.toggle($('#container')[0]);
            });
        });
        $(document).ready(function(){

            $("#AddExpense").click(function(){
                $("#FormAddExpense").show();
            });

            $("#CloseAddExpense").click(function(){
                $("#FormAddExpense").hide();
                $("#txtName").val("");
                $("#txtTags").val("");
                $("#txtDesc").val("");
                $("#txtAmount").val("");
                $("#txtDate").val("");
                $("#optCategory").val("");
                $("#txtPlace").val("");
            });

            $(".editExpense").click(function(){
                $("#FormAddExpense").show();
                $("#formTitle").inntHTML("Edit Expense");
                //check=2;
            });
                var url=window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
                var urlParam=url[0].split("=");
                if(urlParam[0]!="EditID"){
                    $("#FormAddExpense").hide();
                }
        });
    </script>

    <!--skycons-icons-->
    <script src="js/skycons.js"></script>
    <!--//skycons-icons-->

    <style>
        p.expAmount {
            color: chocolate;
            font-size: 15pt;
        }

        .dateStyle {
            font-size: 15pt;
        }

        td span {
            font-size: 13pt;
        }

        td span.fam {
            font-size: 10pt;
            background-color: orange;
        }

        .table-text h5 {
            font-size: 1.8em;
            color: #000;
        }

        .nav-label {
            font-size: 12pt;
        }

        thead * {
            color: #fff;
        }
    </style>
</head>

<body>
    <?php
include_once "Connection.php";

session_start();

if (!isset($_SESSION["UserID"])) {
    header("Location: Login.php");
}
?>

    <div id="wrapper">
        <nav class="navbar-default navbar-static-top" role="navigation">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <h1>
                    <a class="navbar-brand" style="height: auto; font-size: 18pt;" href="index.php">Expense Tracker</a>
                </h1>
            </div>
            <div class=" border-bottom">

                <div class="drop-men">
                    <ul class=" nav_1">

                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle dropdown-at" data-toggle="dropdown">
                                <span class=" name-caret"><?php echo $_SESSION["Name"]; ?>
                                    <i class="caret"></i>
                                </span>
                                <img src="images/user.png">
                            </a>
                            <ul class="dropdown-menu " role="menu">
                                <li>
                                    <a href="Logout.php">
                                        <i class="fa fa-user"></i>Logout</a>
                                </li>
                            </ul>
                        </li>

                    </ul>
                </div>
                <!-- /.navbar-collapse -->
                <div class="clearfix">

                </div>

                <div class="navbar-default sidebar" role="navigation">
                    <div class="sidebar-nav navbar-collapse">
                        <ul class="nav" id="side-menu">
                            <li>
                                <a href="index.php" class="hvr-bounce-to-right" id="AddExpense">
                                    <i class="fa fa-list nav_icon"></i>
                                    <span class="nav-label">All Expenses</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
        </nav>
        <div id="page-wrapper" class="gray-bg dashbard-1">
            <div class="content-main" style="min-height: 750px;">
			
			<?php

				function getLastNDays($days, $format = 'd/m'){
					$m = date("m"); $de= date("d"); $y= date("Y");
					$dateArray = array();
					for($i=0; $i<=$days-1; $i++){
						$dateArray[] = '"' . date($format, mktime(0,0,0,$m,($de-$i),$y)) . '"'; 
					}
					return array_reverse($dateArray);
				}

				function getWeekday($date) {
					return date('w', strtotime($date));
				}
				
				$today = date("Y-m-d");
            	$before7days = date('Y-m-d', strtotime('-7 day', strtotime($today)));

				$last7dates = getLastNDays(7, 'Y-m-d');
				$last7days= getLastNDays(7, 'd');
				$cnt=0;
				foreach ($last7dates as $day) {
					$qry="select SUM(e.Amount) as S from tblexpense e where UserID=".$_SESSION["UserID"]." and DATE(Date)=".$day." order by e.Date asc";
					$rs=mysqli_query($con,$qry);
					$res=mysqli_fetch_assoc($rs);
					$lastWeekData[$cnt++]=$res["S"];
				}

				$cnt=0;
				$qry="select * from tblcategory";
				$rs=mysqli_query($con,$qry);
				while($res=mysqli_fetch_assoc($rs)){
					$qry="select SUM(e.Amount) as S from tblexpense e where UserID=".$_SESSION["UserID"]." and CategoryID=".$res["CategoryID"];
					$rs1=mysqli_query($con,$qry);
					$res1=mysqli_fetch_assoc($rs1);
					$categories[$cnt]=$res["CategoryName"];
					$categoryData[$cnt]=$res1["S"];	
					$cnt++;	
				}
			?>

			<div class="graph">
				<div class="graph-grid">
					<div class="col-md-6 graph-1">
						<div class="grid-1">
							<h4>Category wise expenses</h4>
							<canvas id="bar1" height="300" width="700" style="width: 700px; height: 300px;"></canvas>
							<script>
								var barChartData = {
									labels: <?php print_r(json_encode($categories)); ?>,
									datasets: [{
											fillColor: "#FBB03B",
											strokeColor: "#FBB03B",
											data: <?php print_r(json_encode($categoryData)); ?>
										}
									]

								};
								new Chart(document.getElementById("bar1").getContext("2d")).Bar(barChartData);
							</script>
						</div>
					</div>
					<div class="col-md-6 graph-2">
						<div class="grid-1">
						<h4>Last 7 Days Expense</h4>
							<canvas id="line1" height="300" width="700" style="width: 500px; height: 300px;"></canvas>
							<script>
								var lineChartData = {
									labels: <?php print_r(json_encode($last7days)); ?>,
									datasets: [{
										fillColor: "#fff",
										strokeColor: "#1ABC9C",
										pointColor: "#1ABC9C",
										pointStrokeColor: "#1ABC9C",
										data: <?php print_r(json_encode($lastWeekData)); ?>
									}]

								};
								new Chart(document.getElementById("line1").getContext("2d")).Line(lineChartData);
							</script>
						</div>
					</div>
					<div class="clearfix"> </div>
				</div>
				</div>
			</div>

					</div>

					<div class="copy">
                <p> Design by Ritesh Tailor</p>
            </div>
				</div>
			</div>
			<!---->
			
			<!-- Mainly scripts -->
		<script src="js/jquery.metisMenu.js"></script>
		<script src="js/jquery.slimscroll.min.js"></script>
		<!-- Custom and plugin javascript -->
		<link href="css/custom.css" rel="stylesheet">
		<script src="js/custom.js"></script>
		<script src="js/screenfull.js"></script>
		<script>
		$(function () {
			$('#supported').text('Supported/allowed: ' + !!screenfull.enabled);

			if (!screenfull.enabled) {
				return false;
			}



			$('#toggle').click(function () {
				screenfull.toggle($('#container')[0]);
			});



		});
		</script>

    <!--scrolling js-->
    <script src="js/jquery.nicescroll.js"></script>
    <script src="js/scripts.js"></script>
    <!--//scrolling js-->
    <script src="js/bootstrap.min.js"> </script>
</body>

</html>