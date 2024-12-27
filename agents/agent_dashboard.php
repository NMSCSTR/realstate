<?php
// Start the session to access session variables like 'agent_id'
session_start();

// Check if the 'agent_id' is set in the session, indicating the user is logged in as an agent
if (!isset($_SESSION['agent_id'])) {
    // If not logged in, redirect to the login page
    header('Location: login.php');
    exit(); // Stop further execution of the script after the redirect
}

// Establish a connection to the MySQL database 'oreep360' with the provided credentials
$conn = mysqli_connect("localhost", "root", "", "oreep360");

// Check if the connection was successful
if (!$conn) {
    // If the connection fails, display an error message and terminate the script
    die("Connection failed: " . mysqli_connect_error());
}

// Get the agent's ID from the session
$agent_id = $_SESSION['agent_id'];

// Prepare a query to select all properties listed by the current agent
$sql = "SELECT * FROM properties WHERE agent_id = '$agent_id'";

// Execute the query and store the result in the $result variable
$result = $conn->query($sql);

// Check if the query execution was successful and if there are any results
if ($result && $result->num_rows > 0) {
    // If there are properties, loop through the result set
    while ($property = $result->fetch_assoc()) {
        // For each property, you can display the details (e.g., $property['name'], $property['price'], etc.)
        echo "Property Name: " . $property['name'] . "<br>";
        echo "Price: " . $property['price'] . "<br>";
        // You can add more property details as needed
    }
} else {
    // If no properties are found for the agent, display a message
    echo "No properties found for this agent.";
}

// Close the database connection after finishing the query
mysqli_close($conn);
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
                <h5>Properties by Agent <span><?php echo $_SESSION['agent_id'] ?></span></h5>
                <a href="create.php" class="btn btn-success mb-3">Add New Property</a>

            </div>
            <hr>
            <div class="table-responsive mb-3">
                <table id="myTable" class="display responsive nowrap  caption-top">
                    <caption>List of Properties</caption>
                    <thead>
                        <tr>
                            <th>Property ID</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Address</th>
                            <th>Price</th>
                            <th>Latitude</th>
                            <th>Longitude</th>
                            <th>Cover Image</th>
                            <th>Show to clients</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= $row['property_id']; ?></td>
                            <td><?= $row['name']; ?></td>
                            <td><?= $row['description']; ?></td>
                            <td><?= $row['address']; ?></td>
                            <td><?= $row['price']; ?></td>
                            <td><?= $row['map_latitude']; ?></td>
                            <td><?= $row['map_longitude']; ?></td>
                            <td><?= $row['cover_img']; ?></td>
                            <td><?= $row['show_to_clients']; ?></td>
                            <td>
                                <a href="edit_property.php?id=<?= $row['property_id']; ?>"
                                    class="btn btn-warning btn-sm">EDIT</a>
                                <a href="delete_property.php?id=<?= $row['property_id']; ?>"
                                    class="btn btn-danger btn-sm">DELETE</a>
                                <a href="add_amenities.php?property_id=<?= $row['property_id']; ?>"
                                    class="btn btn-success btn-sm">VIEW AMENITIES</a>
                                <a href="add_image.php?property_id=<?= $row['property_id']; ?>"
                                    class="btn btn-secondary btn-sm">ADD PROPERTY IMAGES</a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>

                </table>
            </div>


            <script src="../bootstrap/js/bootstrap.min.js"></script>
            <script>
            $(document).ready(function() {
                $('#myTable').DataTable({
                    responsive: true
                });
            });
            </script>
</body>

</html>