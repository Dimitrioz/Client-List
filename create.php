<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "test";

// Create connection
$connection = new mysqli($servername, $username, $password, $database);


$name = "";
$lastname = "";
$address = "";
$phone = "";
$email = "";
$comments = "";
// checking if data has been transmitted  
if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
    $name = $_POST["name"];
    $lastname = $_POST["lastname"];
    $address = $_POST["address"];
    $phone = $_POST["phone"];
    $email = $_POST["email"];
    $comments = $_POST["comments"];

    $errorMessage = "";
    $successMessage ="";

  // do while false for no empty field 
    do {
        if ( empty($name) || empty($lastname) || empty($address) || empty($phone) || empty($email) || empty($comments) ) {
          $errorMessage = "All the fields are required";
          break;
        }
        $check_email = $connection->query("SELECT * FROM employees WHERE email = '$email'");
        if ($check_email->num_rows > 0) {
          // Display an error message if the email is already in use
          $errorMessage = "This email is already used";
          break; 
        }  
          else {
          // add new client to database
          $sql = "INSERT INTO employees (name, lastname, address, phone, email, comments) " .
          "VALUES ('$name', '$lastname', '$address', '$phone', '$email', '$comments')";
          $result = $connection->query($sql);
          // error message for new field
          if (!$result) {
          $errorMessage = "Invalid query: " . $connection->error;
          break;
          }
   
        }
      // success message for new field
        $name = "";
        $lastname = "";
        $address = "";
        $phone = "";
        $email = "";
        $comments = "";
     
        $successMessage = "Client added correctly";

        header("location: /test/index.php");
        exit;

    } while (false);
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Shop</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
  <body>
  <body style="background-color: #add8e6;">
    <div class="container my-5">
        <h2>New Client</h2>

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