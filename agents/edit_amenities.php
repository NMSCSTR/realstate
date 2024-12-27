<?php
// Start the session to use session variables
session_start();

// Check if the session variable 'agent_id' is not set
if (!isset($_SESSION['agent_id'])) {
    // Redirect the user to the login page if not logged in
    header('Location: login.php');
    exit(); // Stop further execution of the script
}

// Establish a connection to the MySQL database
$conn = mysqli_connect("localhost", "root", "", "oreep360");

// Check if the connection failed
if (!$conn) {
    // Display an error message and terminate the script if connection failed
    die("Connection failed: " . mysqli_connect_error());
}

// Check if the 'id' parameter is missing or empty in the URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    // Redirect the user to the add_amenities page
    header('Location: add_amenities.php');
    exit(); // Stop further execution of the script
}

// Store the 'id' parameter from the URL in the $amenity_id variable
$amenity_id = $_GET['id'];

// Query the database to fetch details for the specified amenity ID
$fetch = "SELECT * FROM `property_amenities` WHERE `amenity_id` = '$amenity_id'";
$result = mysqli_query($conn, $fetch);

// Check if the query execution failed
if (!$result) {
    // Display an error message and terminate the script if the query fails
    die("Error fetching data: " . mysqli_error($conn));
}

// Fetch the resulting data as an associative array if the query is successful
$get_amenity_name = mysqli_fetch_assoc($result);

// Check if the request method is POST and the 'update_amenity' button was clicked
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_amenity'])) {
    // Get the amenity ID from the form submission
    $amenity_id = $_POST['amenity_id'];
    // Get the updated name from the form submission
    $name = $_POST['name'];

    // Query to update the amenity's name in the database
    $updateqry = "UPDATE `property_amenities` SET `name`='$name' WHERE amenity_id = '$amenity_id'";

    // Check if the update query executed successfully
    if (mysqli_query($conn, $updateqry)) {
        // Redirect the user to the add_amenities page with the related property ID
        header("Location: add_amenities.php?property_id=" . urlencode($get_amenity_name['property_id']));
        exit(); // Stop further execution of the script
    } else {
        // Display an error message if the update query fails
        echo "Error updating amenity: " . mysqli_error($conn);
    }

    // Close the database connection
    mysqli_close($conn);
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Properties</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">

    <!-- DataTables Responsive CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.0/css/responsive.dataTables.min.css">

    <!-- jQuery (necessary for DataTables to work) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

    <!-- DataTables Responsive JS -->
    <script src="https://cdn.datatables.net/responsive/2.4.0/js/dataTables.responsive.min.js"></script>
</head>
<style>
@import url('https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap');

* {
    padding: 0;
    margin: 0;
}

body {
    font-family: "Montserrat", sans-serif;
}

#site-title {
    font-weight: 600;
}
</style>

<body>
    <header>
        <nav class="navbar navbar-expand-lg bg-body-tertiary shadow">
            <div class="container">
                <a class="navbar-brand" id="site-title" href="#">ONLINE REAL ESTATE ECOMMERCE PLATFORM</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText"
                    aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarText">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="index.php">HOME</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="realestate.php">REAL STATES</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="agent.php">AGENTS</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="account.php">ACCOUNT</a>
                        </li>
                    </ul>
                    <span class="navbar-text">
                        <a href="../logout.php" class="btn btn-danger text-white"
                            onclick="return confirm('Are you sure you want to logout?')">
                            <i class="bi bi-box-arrow-in-right"></i> Logout
                        </a>
                    </span>
                </div>
            </div>
        </nav>
    </header>

    <main>
        <div class="container mt-4">
            <div class="d-flex justify-content-between w-100">
                <h5>Edit Amenities</h5>
                <a href="agent_dashboard.php" class="btn btn-success mb-3">Back</a>
            </div>
            <hr>
            <!-- Form para edit ug amenities -->
            <form action="" method="post">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" name="amenity_id" value="<?= $get_amenity_name['amenity_id']?>" id="id">
                    <input type="text" class="form-control" name="name" value="<?= $get_amenity_name['name']?>" id="name" placeholder="Amenity Name">
                    <label for="name">Amenity Name</label>
                </div>
                <button type="submit" name="update_amenity" class="btn btn-primary">Update</button>

            </form>
        
            <script src="../bootstrap/js/bootstrap.min.js"></script>
            <!-- datatable script -->
            <script>
            $(document).ready(function() {
                $('#myTable').DataTable({
                    responsive: true
                });
            });
            </script>
</body>

</html>