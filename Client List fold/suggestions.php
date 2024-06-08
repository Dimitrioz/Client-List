<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    echo json_encode([]);
    exit;
}

// Define database connection variables
$servername = "localhost";
$username = "root";
$password = "";
$database = "test";

// Create connection
$connection = new mysqli($servername, $username, $password, $database);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Check if search query is set
if (isset($_GET['query'])) {
    $query = $_GET['query'];
    $sql = "SELECT name FROM employees WHERE name LIKE '%$query%' OR lastname LIKE '%$query%' LIMIT 10";
    $result = $connection->query($sql);

    $suggestions = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $suggestions[] = $row['name'];
        }
    }
    echo json_encode($suggestions);
} else {
    echo json_encode([]);
}

$connection->close();
?>
