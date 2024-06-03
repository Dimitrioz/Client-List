<?php
$query = $_GET['query'];

// Connect to the database
$connection = new mysqli('hostname', 'username', 'password', 'database');

// Check for errors
if ($connection->connect_error) {
  die("Connection failed: " . $connection->connect_error);
}

// Escape the query to prevent SQL injection
$escapedQuery = $connection->real_escape_string($query);

// Run the query
$result = $connection->query("SELECT * FROM table WHERE column LIKE '%$escapedQuery%'");

// Check if any results were found
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    // Do something with the results
  }
} else {
  echo "No results found.";
}

// Close the connection
$connection->close();
?>
