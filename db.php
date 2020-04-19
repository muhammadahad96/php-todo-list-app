<?php
// database connection

$host = "localhost";
$user = "root";
$pwd = "";
$dbName = "todo_app";

$dsn = "mysql:host=" . $host . ";dbname=" . $dbName;

$connect = new PDO($dsn, $user, $pwd);

session_start();

$_SESSION["user_id"] = "1";
