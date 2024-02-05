<?php
// Check if the user is logged in
session_start();

$serverName = "localhost";
$userNameDb = "root";
$password = "";
$dbName = "databaseinventory";

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$conn = new mysqli($serverName, $userNameDb, $password, $dbName);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (empty($_SESSION['username'])) {
    header("Location: /owl_inventory_client/login.php");
    exit();
}

// if (!isset($_SESSION['username'])) {
//     // The user is not logged in, redirect to login page
//     header("Location: monitoring.php");
//     exit();
// }