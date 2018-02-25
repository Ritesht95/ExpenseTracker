<!DOCTYPE HTML>
<html>

<head>
    <title>Expense Tracker : Home</title>
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
        include_once("Connection.php");

        session_start();

        if(!isset($_SESSION["UserID"])){
            header("Location: Login.php");
        }

        if(isset($_REQUEST["btnSubmit"])){
            $Name=$_REQUEST["txtName"];
            $Desc=$_REQUEST["txtDesc"];
            $Amount=$_REQUEST["txtAmount"];
            $Date=$_REQUEST["txtDate"];
            $Category=$_REQUEST["optCategory"];
            $Place=$_REQUEST["txtPlace"];

            $qry="insert into tblexpense values(null,'".$Name."','".$Desc."',".$Category.",".$Amount.",'".$Date."','".$Place."',".$_SESSION["UserID"].")";
            //echo $qry;
            //exit;
            if(mysqli_query($con,$qry))
            {
                echo '<script>alert("Expense added successfully")</script>';
                header("Location: index.php");
            }
            else
            {
                echo '<script>alert("Oops! Something went wrong")</script>';
            }
        }

        if(isset($_REQUEST["DelID"])){
            $ID=$_REQUEST["DelID"];
            $qry="delete from tblExpense where ExpenseID=".$ID;
            if(mysqli_query($con,$qry))
            {
                echo "<script>Expense deleted successfully</script>";

                header("Location: index.php");
            }
            else
            {
                echo "<script>Oops! Something went wrong</script>";
            }
        }

        if(isset($_REQUEST["EditID"])){
            $ID=$_REQUEST["EditID"];
            $qry="select * from tblExpense where ExpenseID=".$ID;
            $rs=mysqli_query($con,$qry);
            $res=mysqli_fetch_assoc($rs);
            
        }

        if(isset($_REQUEST["btnUpdate"])){

            $Name=$_REQUEST["txtName"];
            $Desc=$_REQUEST["txtDesc"];
            $Amount=$_REQUEST["txtAmount"];
            $Date=$_REQUEST["txtDate"];
            $Category=$_REQUEST["optCategory"];
            $Place=$_REQUEST["txtPlace"];

            $ID=$_REQUEST["EditID"];
            $qry="update tblexpense set Name='".$Name."',Description='".$Desc."',CategoryID=".$Category.",Amount=".$Amount.",Date='".$Date."',Place='".$Place."' where ExpenseID=".$ID;
            if(mysqli_query($con,$qry))
            {
                echo "<script>Expense updated successfully</script>";

                header("Location: index.php");
            }
            else
            {
                echo "<script>Oops! Something went wrong</script>";
            }            
        }

    ?>
    <script language="javascript" type="text/javascript">

function getXMLHTTP() { //fuction to return the xml http object
    var xmlhttp=false;	
    try{
        xmlhttp=new XMLHttpRequest();
    }
    catch(e)	{		
        try{			
            xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");
        }
        catch(e){
            try{
            xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
            }
            catch(e1){
                xmlhttp=false;
            }
        }
    }
        
    return xmlhttp;
}

function getSearchResult(SearchedTerm) 
{
    
    var strURL="getSearchResult.php?search="+SearchedTerm;
    var req = getXMLHTTP();
    
    if (req) {
        
        req.onreadystatechange = function() {
            if (req.readyState == 4) {
                if (req.status == 200) {	
                    document.getElementById('DataTableBody').innerHTML=req.responseText;						
                } else {
                    alert("There was a problem while using XMLHTTP:\n" + req.statusText);
                }
            }				
        }			
        req.open("GET", strURL, true);
        req.send(null);
    }		
}

function getSearchResult1(SDate,EDate,Category) 
{
    
    var strURL="getSearchResult.php?SDate="+SDate+"&EDate="+EDate+"&Category="+Category;
    var req = getXMLHTTP();
    
    if (req) {
        
        req.onreadystatechange = function() {
            if (req.readyState == 4) {
                if (req.status == 200) {	
                    document.getElementById('DataTableBody').innerHTML=req.responseText;						
                } else {
                    alert("There was a problem while using XMLHTTP:\n" + req.statusText);
                }
            }				
        }			
        req.open("GET", strURL, true);
        req.send(null);
    }		
}
</script>
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
                                <a href="#" class="hvr-bounce-to-right" id="AddExpense">
                                    <i class="fa fa-plus nav_icon"></i>
                                    <span class="nav-label">Add Expense</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="hvr-bounce-to-right" onclick="getSearchResult('');">
                                    <i class="fa fa-list nav_icon" id="today"></i>
                                    <span class="nav-label">All Expenses</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="hvr-bounce-to-right" onclick="getSearchResult('today');">
                                    <i class="fa fa-calendar-alt nav_icon" id="today"></i>
                                    <span class="nav-label">Today</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="hvr-bounce-to-right" onclick="getSearchResult('yesterday');">
                                    <i class="fa fa-calendar-alt nav_icon" id="yesterday"></i>
                                    <span class="nav-label">Yesterday</span>
                                </a>
                            </li>
                            <li>
                                <a href="Graphs.php" class="hvr-bounce-to-right" onclick="getSearchResult('yesterday');">
                                    <i class="fa fa-chart-line nav_icon" id="yesterday"></i>
                                    <span class="nav-label">Graphs</span>
                                </a>
                            </li>                            
                        </ul>
                    </div>
                </div>
        </nav>
        <div id="page-wrapper" class="gray-bg dashbard-1">
            <div class="content-main" style="min-height: 750px;">

                <div class="grid-form1" style="margin: 2%;" id="FormAddExpense">
                    <h3 id="formTitle">Add Expense</h3>
                    <form class=" row" method="post">
                        <div class="tab-content">
                            <div class="tab-pane active" id="horizontal-form">                           
                                <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <label class="col-sm-3 control-label">Name your expense</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control2" id="txtName" name="txtName" placeholder="Name your expense" required value='<?php if(isset($_REQUEST["EditID"])) echo $res["Name"]; ?>' >
                                    </div>
                                </div>
                                <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <label for="txtarea1" class="col-sm-3 control-label">Description</label>
                                    <div class="col-sm-9">
                                        <textarea name="txtDesc" id="txtDesc" cols="50" rows="5" style="height: 80px;" class="form-control1" required><?php if(isset($_REQUEST["EditID"])) echo $res["Description"]; ?></textarea>
                                    </div>
                                </div>


                                <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <label class="col-sm-3 control-label">Amount</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control2" id="txtAmount" name="txtAmount" placeholder="Expense amount" required value='<?php if(isset($_REQUEST["EditID"])) echo $res["Amount"]; ?>'> 
                                    </div>
                                </div>

                                <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <label class="col-sm-3 control-label">Date</label>
                                    <div class="col-sm-9">
                                        <input type="date" class="form-control2" id="txtDate" name="txtDate" required value='<?php if(isset($_REQUEST["EditID"])) echo $res["Date"]; ?>'>
                                    </div>
                                </div>
                                <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <label class="col-sm-3 control-label">Category</label>
                                    <div class="col-sm-9">
                                        <!-- <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css" rel="stylesheet"> -->
                                        <select class="form-control" id="optCategory" name="optCategory" required>
                                        <?php
                                        
                                        $qry="select * from tblcategory";
                                        $rs=mysqli_query($con,$qry);
                                        while($doc=mysqli_fetch_assoc($rs))
                                        {
                                            if(isset($_REQUEST["EditID"]))
                                            {
                                                if($res["CategoryID"]==$doc["CategoryID"])
                                                {
                                        ?>
                                            <option value='<?php echo $doc["CategoryID"] ?>' selected><?php echo $doc["CategoryName"] ?></option>
                                        <?php
                                                }
                                                else
                                                {
                                        ?>
                                            <option value='<?php echo $doc["CategoryID"] ?>'><?php echo $doc["CategoryName"] ?></option>
                                        <?php
                                                }
                                            }
                                            else
                                            {
                                        ?>
                                            <option value='<?php echo $doc["CategoryID"] ?>'><?php echo $doc["CategoryName"] ?></option>
                                        <?php

                                            }
                                        }
                                        ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <label class="col-sm-3 control-label">Place</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control2" id="txtPlace" name="txtPlace" placeholder="Name the place where you spent this amount" required value='<?php if(isset($_REQUEST["EditID"])) echo $res["Place"]; ?>'>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-8 col-sm-offset-2">
                            <?php
                                if(isset($_REQUEST["EditID"]))
                                {
                            ?>
                                <input type="submit" name="btnUpdate" id="btnUpdate" class="btn-primary btn" value="Update">                                
                            <?php 
                                }
                                else
                                {
                            ?>
                                <input type="submit" name="btnSubmit" id="btnSubmit" class="btn-primary btn" value="Submit">
                            <?php
                                }
                            ?>
                                <button id="CloseAddExpense" class="btn-default btn">Cancel</button>
                                <button class="btn-inverse btn">Reset</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="grid-form1" style="margin: 2%;">
                    <h3>Filter By</h3>
                    <div class="row">
                        <div class="col-md-8">
                            <!-- <form method="post"> -->
                                <div class="btn-group">
                                    <label>Start Date</label>
                                    <input type="date" id="txtSDate" name="txtSDate" class="form-control col-md-2" required>
                                </div>
                                <div class="btn-group">
                                    <label>End Date</label>
                                    <input type="date" id="txtEDate" name="txtEDate" class="form-control col-md-2" required>
                                </div>
                                <div class="btn-group">
                                    <label>Category</label>
                                    <select class="form-control col-md-2" id="filterCategory" name="filterCategory" required>
                                        <option value="-1">Select Category</option>
                                    <?php
                                            
                                        $qry="select * from tblcategory";
                                        $rs=mysqli_query($con,$qry);
                                        while($doc=mysqli_fetch_assoc($rs))
                                        {
                                    ?>
                                        <option value='<?php echo $doc["CategoryID"] ?>'><?php echo $doc["CategoryName"] ?></option>
                                    <?php
                                        }
                                    ?>
                                    </select>
                                </div>      
                                <div class="col-sm-12">&nbsp;</div>
                                <div class="col-sm-8">
                                    <button name="btnFilter" id="btnFilter" class="btn-success btn" onclick="getSearchResult1(txtSDate.value,txtEDate.value,filterCategory.value)">Filter</button>
                                </div>                          
                            <!-- </form> -->
                        </div>
                        <div class="col-md-4">
                        <br>
                            <div class="btn-group m-r-sm mail-hidden-options col-md-offset-2 col-md-10" style="display: inline-block;">
                                <div class="input-group input-group-in">
                                    <input type="text" name="txtSearch" id="txtSearch" style="margin-top:20px;" class="form-control2 input-search" placeholder="Search...">
                                    <span class="input-group-btn">
                                        <button class="btn btn-success" type="button" style="margin-top:20px;" onClick="getSearchResult(txtSearch.value);">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- </div> -->
                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-12 col-xs-12">
                        <div class="tab-pane active text-style" id="tab1" style="padding :0% 2% 2% 2%;">
                            <div class="inbox-right">

                                <div class="mailbox-content">

                                    <table class="table table-striped table-hover table-responsive">
                                        <thead class="bg-primary">
                                            <tr>                                                
                                                <td class="table-text">
                                                    <h4>Expense Title</h4>
                                                </td>
                                                <td>
                                                    <h4>Category</h4>
                                                </td>
                                                <td>
                                                    <h4>Amount</h4>
                                                </td>
                                                <td>
                                                    <h4>Date</h4>
                                                </td>
                                                <td>
                                                    <h4>Place</h4>
                                                </td>
                                                <td>
                                                    <h4>Edit</h4>
                                                </td>
                                                <td>
                                                    <h4>Delete</h4>
                                                </td>
                                            </tr>
                                        </thead>
                                        <tbody id="DataTableBody">
                                        <?php 
                                            $qry="select e.*,c.* from tblexpense e,tblCategory c where UserID=".$_SESSION["UserID"]." and e.CategoryID=c.CategoryID order by e.Date asc";
                                            $rs=mysqli_query($con, $qry);
                                            while($doc=mysqli_fetch_assoc($rs)){                                           
                                        ?>
                                        <tr class="table-row">
                                            <td class="table-text">
                                                <h5><?php echo $doc["Name"]; ?></h5>
                                                <p><?php echo $doc["Description"]; ?></p>
                                            </td>
                                            <td>
                                                <span class="fam"><?php echo $doc["CategoryName"]; ?></span>
                                            </td>
                                            <td>
                                                <p class="expAmount"><?php echo $doc["Amount"]; ?>&nbsp;
                                                    <i class="fa fa-rupee-sign" style="color: chocolate;"></i>
                                                </p>
                                            </td>
                                            <td class="march">
                                                <p class="dateStyle">
                                                    <?php 
                                                        $today = date("Y-m-d");  
                                                        $yesterday = date('Y-m-d', strtotime('-1 day', strtotime($today)));
                                                        $date=(new DateTime($doc["Date"]))->format('Y-m-d');        
                                                        //$time=(new DateTime($doc["Date"]))->format('H:i:s');
                                                        
                                                        if($today==$date) 
                                                            echo "Today";
                                                        else if($yesterday==$date)
                                                            echo "Yesterday";   
                                                        else 
                                                            echo $date;  
                                                    ?>
                                                    </p>
                                            </td>
                                            <td>
                                                <p class="dateStyle"><?php echo $doc["Place"]; ?></p>
                                            </td>
                                            <td>
                                                <a href='index.php?EditID=<?php echo $doc["ExpenseID"]; ?>' class="editExpense">
                                                    <i class="fa fa-2x fa-pencil-alt icon-state-warning"></i>
                                                </a>
                                            </td>
                                            <td>
                                                <a href='index.php?DelID=<?php echo $doc["ExpenseID"]; ?>'>
                                                    <i class="fa fa-2x fa-trash icon-state-warning"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <?php
                                            }
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
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
        <!--scrolling js-->
        <script src="js/jquery.nicescroll.js"></script>
        <script src="js/scripts.js"></script>
        <!--//scrolling js-->
        <script src="js/bootstrap.min.js"> </script>
</body>

</html>