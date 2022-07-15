<?php
$db_driver = "mysql";
$host = "localhost";
$database = "iteh2lb1var4";
$dsn = "$db_driver:host=$host; dbname=$database";
$username = "root";
$password = "";
$dbh = new PDO($dsn, $username, $password);
?>