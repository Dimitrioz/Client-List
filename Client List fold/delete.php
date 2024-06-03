<?php
if ( isset($_GET["id"]) ) {
    $id = $_GET["id"];

$servername = "localhost";
$username = "root";
$password = "";
$database = "test";

// Create connection
$connection = new mysqli($servername, $username, $password, $database);

// SQL query to delete lists
$sql = "DELETE FROM employees WHERE id=$id";
$connection->query($sql);
}

header("location: /test/index.php");
exit;
?>