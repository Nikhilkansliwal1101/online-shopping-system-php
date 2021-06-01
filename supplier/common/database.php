<?php
$servername="localhost:3307";
$dbname="online";
$password="";
$user="root";
$con=mysqli_connect($servername,$user,$password,$dbname);
if(!$con)
{
    echo "can't connect ";
    echo mysqli_error($con);
}