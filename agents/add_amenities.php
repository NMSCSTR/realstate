<?php
// Start a session to access session variables
session_start();

// Check if the 'agent_id' session variable is set, meaning the user is logged in as an agent
if (!isset($_SESSION['agent_id'])) {
    // If the user is not logged in, redirect them to the login page
    header('Location: login.php');
    exit(); // Stop further script execution
}

// Connect to the MySQL database 'oreep360' with the provided credentials
$conn = mysqli_connect("localhost", "root", "", "oreep360");

// Check if the 'property_id' is passed in the URL as a GET parameter
if (isset($_GET['property_id'])) {
    // Retrieve and sanitize the property_id to ensure it's an integer
    $property_id = intval($_GET['property_id']); 
    
    // Prepare a query to fetch property details using the provided property_id
    $query = "SELECT * FROM properties WHERE property_id = $property_id";
    $result = mysqli_query($conn, $query);

    // Check if the property is found in the database
    if ($result && mysqli_num_rows($result) > 0) {
        // Fetch the property details into an associative array
        $row = mysqli_fetch_assoc($result);
    } else {
        // If no property is found, display an error message
        echo "Property not found.";
    }
} else {
    // If no property_id is provided in the URL, display an error message
    echo "No property ID provided.";
}

// Fetch all amenities related to the current property_id
$sql = "SELECT * FROM `property_amenities` WHERE property_id = '$property_id'";
$results = $conn->query($sql);

// If the form is submitted (POST request), proceed to handle the form data
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize the input values to prevent SQL injection
    $aminity_name = mysqli_real_escape_string($conn, $_POST['aminity_name']);
    $property_id = mysqli_real_escape_string($conn, $property_id);

    // Check if the amenity already exists for the given property_id
    $check_query = "SELECT * FROM `property_amenities` WHERE `property_id` = '$property_id' AND `name` = '$aminity_name'";
    $check_result = mysqli_query($conn, $check_query);

    // If the amenity already exists, alert the user
    if (mysqli_num_rows($check_result) > 0) {
        echo '<script>alert("Amenity already exists.");</script>';
    } else {
        // If the amenity does not exist, insert the new amenity into the database
        $query = "INSERT INTO `property_amenities` (`property_id`, `name`) VALUES ('$property_id', '$aminity_name')";
        
        // If the query is successful, redirect to the 'add_amenities.php' page with the property_id as a parameter
        if (mysqli_query($conn, $query)) {
            header("Location: add_amenities.php?property_id=$property_id");
        } else {
            // If there's an error inserting the amenity, display an error message
            echo "Error adding amenity: " . mysqli_error($conn);
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aminities</title>
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
                        <button class="btn btn-danger" type="button" data-bs-toggle="offcanvas"
                            data-bs-target="#staticBackdrop" aria-controls="staticBackdrop">
                            <i class="bi bi-box-arrow-in-right"></i> Logout
                        </button>
                    </span>
                </div>
            </div>
        </nav>
    </header>

    <main>
        <div class="container mt-4">
            <div class="d-flex justify-content-between w-100">
                <h5>View Aminities for <span class="text-success text-bolder"><?= $row['name'] ?></span></h5>
                <a href="agent_dashboard.php" class="btn btn-secondary btn-sm mb-3">Back</a>
            </div>
            <hr>
            <!-- Displaying all amenities using table -->
            <div class="table-responsive mb-3">
                <table id="myTable" class="display responsive nowrap caption-top">
                    <caption>List of Aminities</caption>
                    <thead>
                        <tr>
                            <th>Property ID</th>
                            <th>Amenities</th>
                            <th>Actions</th>

                        </tr>
                    </thead>
                    <tbody>
                        <!-- Loop all amenities stored in the database -->
                        <?php while ($rows = $results->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($rows['property_id']); ?></td>
                            <td>
                                <?php
                                $property_id = $rows['property_id'];
                                $amenities_query = "SELECT name FROM `property_amenities` WHERE property_id = '$property_id'";
                                $amenities_result = $conn->query($amenities_query);

                                if ($amenities_result && $amenities_result->num_rows > 0) {
                                 $amenity = $amenities_result->fetch_assoc();
                                        echo '<span class="badge rounded-pill text-bg-light shadow">' . htmlspecialchars($amenity['name']) . '</span> ';
                                    
                                } else {
                                    echo '<span class="text-muted">No amenities</span>';
                                }
                                ?>
                            </td>
                            <td>
                                <!-- code para sa pag update sa amenity -->
                                <a href="edit_amenities.php?id=<?= htmlspecialchars($rows['amenity_id']); ?>"
                                    class="btn btn-sm btn-outline-primary">Edit</a>
                                <!-- code para delete sa amenity sa property -->
                                <a href="delete_amenities.php?id=<?= htmlspecialchars($rows['amenity_id']); ?>&property_id=<?= htmlspecialchars($rows['property_id']); ?>"
                                    onclick="return confirm('Are you sure you want to delete?')"
                                    class="btn btn-sm btn-outline-danger">Delete</a>

                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
            <!-- Form para add ug amenty and backend code naas taas -->
            <form action="" method="post">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" name="aminity_name" id="aminity_name"
                        placeholder="Aminity Name" required>
                    <label for="aminity_name">Aminity Name</label>
                </div>
                <button class="btn btn-primary btn-sm">Add Aminity</button>
            </form>

        </div>


        <script src="../bootstrap/js/bootstrap.min.js"></script>
        <!-- Initializing datatable -->
        <script>
        $(document).ready(function() {
            $('#myTable').DataTable({
                responsive: true
            });
        });
        </script>
</body>

</html>