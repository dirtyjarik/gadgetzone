<?php
$servername = "MySQL-8.2";
$username = "root";
$password = "";
$dbname = "gadgetzone";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}
$conn->set_charset("utf8mb4"); 
?>