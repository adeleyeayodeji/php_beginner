<?php
$host = "localhost";
$database = "phpbeginner";
$user = "root";
$password = "root";
//Connecting to MySQL database
$connection = mysqli_connect($host, $user, $password, $database) or die("Database can not connect");
//set global
$GLOBALS["connection"] = $connection;
