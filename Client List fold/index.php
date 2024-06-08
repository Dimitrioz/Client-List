<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
    if (isset($_POST['active'])) {
        $id = intval($_POST['id']);
        $active = intval($_POST['active']);
        $sql = "UPDATE employees SET active = $active WHERE id = $id";
        $connection->query($sql);
      }
      $active = intval(file_get_contents("active_$row[id].txt"));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My shop</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
</head>
<body>
<body style="background-color: #add8e6;"> 
    <div class="container my-5">
        <h2>List of Clients</h2> 
        <a class="btn btn-success" href="/test/create.php" role="button">New Client</a>  
        <a class="btn btn-warning" href="/test/logout.php" role="button">Logout</a>
        <a class="btn btn-danger" href="/test/reset_password.php" role="button">Change Your Password</a> 
        <br>
        <form action="search.php" method="GET">
  <input type="text" name="query">
  <input type="submit" value="Search">
</form>

</form>
        <table class="table">
            <thread>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Last_name</th>
                    <th>Address</th>
                    <th>Phone_number</th>
                    <th>Email</th>
                    <th>Date</th>
                    <th>Active</th>
                </tr>
            </thread>
            <tbody>
                <?php
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

                // Read all row from database table
                $sql = "SELECT * FROM employees";
                $result = $connection->query($sql);
                

                if (!$result) {
                    die("Invalid query: " . $connection->error);
                }

                // Read data of each row
                while($row = $result->fetch_assoc()) {
                    $active = $row['active'];
                    if (isset($_POST['active'])) {
                        $id = intval($_POST['id']);
                        $active = intval($_POST['active']);
                        // Update the active value in the database
                        $sql = "UPDATE employees SET active = $active WHERE id = $id";
                        $connection->query($sql);
                        $id = intval($_POST['id']);
                        $active = intval($_POST['active']);
                        $sql = "UPDATE employees SET active = $active WHERE id = $id";
                        $connection->query($sql);
                    }
                      
                    echo"
                    <tr>
                         <td>$row[id]</td>
                         <td>$row[name]</td>
                         <td>$row[lastname]</td>
                         <td>$row[address]</td>
                         <td>$row[phone]</td>
                         <td>$row[email]</td>
                         <td>$row[created_at]</td>
                         <td>
                         <form method='post'>
                         <input type='checkbox' name='active' value='1' " . ($active ? "checked" : "") . ">
                         <input type='hidden' name='id' value='$row[id]'>
                       </form>
                        </td>
                        <td>
                              <a class='btn btn-primary btn-sm' href='/test/read.php?id=$row[id]'>View</a>
                              <a class='btn btn-secondary btn-sm' href='/test/update.php?id=$row[id]'>Edit</a>
                              <a class='btn btn-danger btn-sm' href='/test/delete.php?id=$row[id]'>Delete</a>
                    </td>
                </tr>
                    ";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
   