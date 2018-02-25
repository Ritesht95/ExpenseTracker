<?php 

    include_once("Connection.php");
    session_start();

?>
<?php    
    if(isset($_REQUEST["SDate"])||isset($_REQUEST["EDate"])||isset($_REQUEST["Category"]))
    {
        $SDate=$_REQUEST["SDate"];
        $EDate=$_REQUEST["EDate"];
        $Category=$_REQUEST["Category"];
        if($Category!=-1)
        {
            $qry="select e.*,c.* from tblexpense e,tblCategory c where UserID=".$_SESSION["UserID"]." and e.CategoryID=c.CategoryID and e.CategoryID=".$Category." and DATE(Date) between '".$SDate."' and '".$EDate."' order by e.Date asc";    
        }
        else
        {
            $qry="select e.*,c.* from tblexpense e,tblCategory c where UserID=".$_SESSION["UserID"]." and e.CategoryID=c.CategoryID and DATE(Date) between '".$SDate."' and '".$EDate."' order by e.Date asc";    
        }
    }
    else
    {
        $searchTerm=$_REQUEST['search'];
        if($searchTerm=="today")
        {
            //echo "dsv";
            $today = date("Y-m-d");
            $qry="select e.*,c.* from tblexpense e,tblCategory c where UserID=".$_SESSION["UserID"]." and e.CategoryID=c.CategoryID and DATE(Date)='".$today."' order by e.Date asc";
        }
        else if($searchTerm=="yesterday")
        {
            //echo "dsv";
            $today = date("Y-m-d");
            $yesterday = date('Y-m-d', strtotime('-1 day', strtotime($today)));
            $qry="select e.*,c.* from tblexpense e,tblCategory c where UserID=".$_SESSION["UserID"]." and e.CategoryID=c.CategoryID and DATE(Date)='".$yesterday."' order by e.Date asc";
        }    
        else if($searchTerm!=""){
            $searchTerm="%".$searchTerm."%";        
            $qry="select e.*,c.* from tblexpense e,tblCategory c where e.UserID=".$_SESSION["UserID"]." and e.CategoryID=c.CategoryID and e.Name like '".$searchTerm."'";
        }
        else
        {
            $qry="select e.*,c.* from tblexpense e,tblCategory c where UserID=".$_SESSION["UserID"]." and e.CategoryID=c.CategoryID order by e.Date asc";
        }
    }
    $rs=mysqli_query($con,$qry);
    while($doc=mysqli_fetch_assoc($rs)){
?>
    <tr class="table-row">
        <td class="table-text">
            <h5><?php echo $doc["Name"]; ?></h5>
            <p><?php echo $doc["Description"]; ?></p>
        </td>
        <td>
            <i class="fa fa-2x fa-utensils" style="align-self: center; padding: 5px 12px;"></i>
            <br>
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
            <a href="#">
                <i class="fa fa-2x fa-pencil-alt icon-state-warning"></i>
            </a>
        </td>
        <td>
            <a href="#">
                <i class="fa fa-2x fa-trash icon-state-warning"></i>
            </a>
        </td>
    </tr>
<?php
        }
?>