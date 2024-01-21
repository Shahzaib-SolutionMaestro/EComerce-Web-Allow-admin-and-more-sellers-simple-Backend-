<?php
    $dbhost = 'localhost';
    $dbuser = 'root';
    $dbpassword = '';
    $dbname = 'project2';
    $con = mysqli_connect($dbhost, $dbuser, $dbpassword, $dbname);
    if(!$con)
    {
        die($con->error);
    }
?>