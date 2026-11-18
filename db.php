<?php

$localhost = "localhost";
$username = "root";
$password = "";
$db_name = "grading";


$conn = new mysqli($localhost, $username, $password, $db_name);

if ($conn->connect_error) {
    die("". $conn->connect_error);
}
?>