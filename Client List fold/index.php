<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to the login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
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

// Initialize query variable
$query = "";

// Check if search query is set
if (isset($_GET['query'])) {
    $query = $_GET['query'];
    // Prepare SQL query with the search term
    $sql = "SELECT * FROM employees WHERE name LIKE '%$query%' OR lastname LIKE '%$query%' OR address LIKE '%$query%' OR phone LIKE '%$query%' OR email LIKE '%$query%'";
} else {
    // Default SQL query to fetch all employees
    $sql = "SELECT * FROM employees";
}

// Determine the current page
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$perPage = 10; // Number of clients per page
$offset = ($page - 1) * $perPage;

// Get the total number of clients
$totalClientsResult = $connection->query($sql);
$totalClients = $totalClientsResult->num_rows;

// Fetch only the clients for the current page
$sql .= " LIMIT $perPage OFFSET $offset";
$result = $connection->query($sql);

if (!$result) {
    die("Invalid query: " . $connection->error);
}

// Handle form submission for activating/deactivating employees
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['active'])) {
    $id = intval($_POST['id']);
    $active = intval($_POST['active']);
    $sql = "UPDATE employees SET active = $active WHERE id = $id";
    $connection->query($sql);
    // Redirect to avoid form resubmission
    header("Location: index.php?page=$page&query=" . urlencode($query));
    exit;
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="style_for_index.css">
</head>
<body style="background-color: rgba(165, 210, 255, .4);"> 
    <div class="container my-5">
        <h2>List of Clients</h2> 
        <a class="btn btn-success" href="/test/create.php" role="button">New Client</a>  
        <a class="btn btn-secondary" href="/test/logout.php" role="button">Logout</a>
        <a class="btn btn-danger" href="/test/reset_password.php" role="button">Change Your Password</a> 
        <br>
        <div class="search-container">
            <form action="index.php" method="GET" class="d-flex">
                <input type="text" id="search" name="query" value="<?php echo htmlspecialchars($query); ?>" autocomplete="off" class="form-control">
                <button type="submit" class="btn btn-primary">Search</button>
                <button type="button" class="btn btn-secondary clear-btn" id="clear-btn">Clear</button>
                <div id="suggestions"></div>
            </form>
        </div>

        <table class="table mt-3">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Last Name</th>
                    <th>Address</th>
                    <th>Phone Number</th>
                    <th>Email</th>
                    <th>Date</th>
                    <th>Active</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Read data of each row
                while($row = $result->fetch_assoc()) {
                    $active = $row['active'];
                    
                    echo "
                    <tr>
                         <td>{$row['id']}</td>
                         <td>{$row['name']}</td>
                         <td>{$row['lastname']}</td>
                         <td>{$row['address']}</td>
                         <td>{$row['phone']}</td>
                         <td>{$row['email']}</td>
                         <td>{$row['created_at']}</td>
                         <td>
                         <form method='post'>
                             <input type='hidden' name='id' value='{$row['id']}'>
                             <input type='hidden' name='page' value='$page'>
                             <input type='hidden' name='query' value='" . htmlspecialchars($query) . "'>
                             <input type='checkbox' name='active' value='1' " . ($active ? "checked" : "") . " onchange='this.form.submit()'>
                             <input type='hidden' name='active' value='" . ($active ? "0" : "1") . "'>
                         </form>
                         </td>
                         <td>
                              <a class='btn btn-primary btn-sm' href='/test/read.php?id={$row['id']}'>View</a>
                              <a class='btn btn-warning btn-sm' href='/test/update.php?id={$row['id']}'>Edit</a>
                              <a class='btn btn-danger btn-sm' href='/test/delete.php?id={$row['id']}'>Delete</a>
                         </td>
                    </tr>
                    ";
                }
                ?>
            </tbody>
        </table>

        <!-- Pagination -->
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">
                <?php
                $totalPages = ceil($totalClients / $perPage);
                for ($i = 1; $i <= $totalPages; $i++) {
                    $activeClass = ($i == $page) ? 'active' : '';
                    echo "<li class='page-item $activeClass'><a class='page-link' href='index.php?page=$i&query=" . urlencode($query) . "'>$i</a></li>";
                }
                ?>
            </ul>
        </nav>
    </div>

    <script>
        $(document).ready(function() {
            const $search = $('#search');
            const $clearBtn = $('#clear-btn');

            // Handle input event on search field
            $search.on('input', function() {
                let query = $(this).val();
                if (query.length > 0) {
                    // Fetch suggestions from the server
                    $.ajax({
                        url: 'suggestions.php',
                        method: 'GET',
                        data: { query: query },
                        success: function(data) {
                            let suggestions = JSON.parse(data);
                            if (suggestions.length > 0) {
                                let suggestionsHtml = suggestions.map(item => `<div class="suggestion-item">${item}</div>`).join('');
                                $('#suggestions').html(suggestionsHtml).show();
                            } else {
                                $('#suggestions').hide();
                            }
                        }
                    });
                    // Show clear button when there is input
                    $clearBtn.show();
                } else {
                    $('#suggestions').hide();
                    $clearBtn.hide();
                }
            });

            // Handle click event on suggestion items
            $(document).on('click', '.suggestion-item', function() {
                $search.val($(this).text());
                $('#suggestions').hide();
                $clearBtn.show();
            });

            // Handle click event on clear button
            $clearBtn.on('click', function() {
                $search.val('');
                $('#suggestions').hide();
                $clearBtn.hide();
                $search.focus();
            });
        });
    </script>
</body>
</html>
