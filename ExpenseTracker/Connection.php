<?php
    $con = mysqli_connect("localhost","root","","exptracker");

    if (!$con)
    {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
?>