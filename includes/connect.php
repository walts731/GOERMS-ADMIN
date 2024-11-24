<?php
// Database Connection
$host = 'localhost';
$db = 'GOERMS_ADMIN';
$user = 'root';
$password = '';
$conn = new mysqli($host, $user, $password, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>