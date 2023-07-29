<?php
$host = "localhost";
$database = "phpbeginner";
$user = "root";
$password = "root";
//Connecting to MySQL database
$connection = mysqli_connect($host, $user, $password, $database) or die("Database can not connect");
//check if sql_mode does not include 'ONLY_FULL_GROUP_BY'  
$sql_mode = mysqli_query($connection, "SELECT @@sql_mode");
$sql_mode = mysqli_fetch_assoc($sql_mode);
if (strpos($sql_mode['@@sql_mode'], 'ONLY_FULL_GROUP_BY') === false) {
    mysqli_query($connection, "SET SESSION sql_mode=(SELECT CONCAT(@@sql_mode, ',ONLY_FULL_GROUP_BY'))");
}

//set global
$GLOBALS["connection"] = $connection;
