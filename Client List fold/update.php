<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "test";

// Create connection
$connection = new mysqli($servername, $username, $password, $database);


$id = "";
$name = "";
$lastname = "";
$address = "";
$phone = "";
$email = "";
$comments = "";

$errorMessage = "";
$successMessage = "";

if ( $_SERVER['REQUEST_METHOD'] == 'GET' ) {
    // GET method: Show the data of the client

    if( !isset($_GET["id"]) ) {
        header("location: /test/index.php");
        exit;
    }

    $id = $_GET["id"];

    // read the row of the selected client from database table
    $sql = "SELECT * FROM employees WHERE id=$id";
    $result = $connection->query($sql);
    $row = $result->fetch_assoc();

    if (!$row) {
        header("location: /test/index.php");    
        exit;
    }

    $name = $row["name"];
    $lastname = $row["lastname"];
    $address = $row["address"];
    $phone = $row["phone"];
    $email = $row["email"];
    $comments = $row["comments"];
}
else {
    // POST method: Update the data of the client

    $id = $_POST["id"];
    $name = $_POST["name"];
    $lastname = $_POST["lastname"];
    $address = $_POST["address"];
    $phone = $_POST["phone"];
    $email = $_POST["email"];
    $comments = $_POST["comments"];
      // Check for no empty field
      do {
        if (empty($id) || empty($name) || empty($lastname) || empty($address) || empty($phone) || empty($email) || empty($comments) ) {
            $errorMessage = "All the fields are required";
            break;
        }
      // For update
        $sql = "UPDATE employees " . 
               "SET name = '$name', lastname = '$lastname', address = '$address', phone = '$phone', email = '$email', comments = '$comments' " . 
               "WHERE id = $id";


        $result = $connection->query($sql);

        if (!$result) {
            $errorMessage = "Invalid query: " . $connection->error;
            break;
        }

        $successMessage = "Costumer updated correctly";

        header("location: /test/index.php");
        exit;

    } while (true);
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Site</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
  <body>
  <body style="background-color: #add8e6;">
    <div class="container my-5">
        <h2>Edit Client</h2>

        <?php
        if ( !empty($errorMessage) ) { // check if error message is empty
          echo "
          <div class='alert alert-warning alert-dismissible fade show' role='alert'>
              <strong>$errorMessage</strong>
              <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
              </div>
          ";
        }
        ?>

        <form method="post">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
           <div class="row mb-3">
             <label class="col-sm-3 col-from-label">Name</label>
             <div class="col-sm-6">
                  <input type="text" class="from-control" name="name" value="<?php echo $name; ?>">
             </div>
           </div>
           <div class="row mb-3">
             <label class="col-sm-3 col-from-label">Last_name</label>
             <div class="col-sm-6">
                  <input type="text" class="from-control" name="lastname" value="<?php echo $lastname; ?>">
             </div>
           </div>
           <div class="row mb-3">
             <label class="col-sm-3 col-from-label">Address</label>
             <div class="col-sm-6">
                  <input type="text" class="from-control" name="address" value="<?php echo $address; ?>">
             </div>
           </div>
           <div class="row mb-3">
             <label class="col-sm-3 col-from-label">Phone_number</label>
             <div class="col-sm-6">
                  <input type="text" class="from-control" name="phone" value="<?php echo $phone; ?>">
             </div>
           </div>
           <div class="row mb-3">
             <label class="col-sm-3 col-from-label">Email</label>
             <div class="col-sm-6">
                  <input type="text" class="from-control" name="email" value="<?php echo $email; ?>">
             </div>
           </div>
           <div class="row mb-3">
             <label class="col-sm-3 col-from-label">Comments</label>
             <div class="col-sm-6">
                  <input type="text" class="from-control" name="comments" value="<?php echo $comments; ?>">
             </div>
           </div>


           <?php
           if ( !empty($successMessage) ) { // check if success message is empty
            echo "
            <div class='row mb-3'>
                <div class='offset-sm-3 col-sm-6'>
                <div class='alert alert-success alert-dismissible fade show' role='alert'>
                     <strong>$successMessage</strong>
                     <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>
              </div>
            </div>
            ";
           }
           ?>
           
           <div class="row mb-3">
             <div class="offset-sm-3 col-sm-3 d-grid">
                  <button type="submit" class="btn btn-primary">Submit</button> 
             </div>
             <div class="col-sm-3 d-grid">
                    <a class="btn btn-outline-primary" href="/test/index.php" role="button">Cancel</a>
              </div>
           </div>
        </form>
    </div>
  </body>
  </html>