<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1); 
error_reporting(E_ALL); 

session_start();
if (!isset($_SESSION['agent_id'])) {
    header('Location: ../index.php');
    exit();
}

$conn = mysqli_connect("localhost", "root", "", "oreep360");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $agent_id = $_SESSION['agent_id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $address = $_POST['address'];
    $price = $_POST['price'];
    $map_latitude = $_POST['map_latitude'];
    $map_longitude = $_POST['map_longitude'];
    $show_to_clients = $_POST['show_to_clients'];
    
    // Handle file upload
    $cover_img_path = null;
    if (isset($_FILES['cover_img']) && $_FILES['cover_img']['error'] === UPLOAD_ERR_OK) {
        $file = $_FILES['cover_img'];
        
        // Generate a unique folder name
        $randomFolder = uniqid('property_', true);
        $uploadDir = "uploads/properties/$randomFolder/";
        
        // Create the directory if it doesn't exist
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        
        // Sanitize file name and determine the target path
        $fileName = basename($file['name']);
        $filePath = $uploadDir . $fileName;
        
        // Move the file to the target directory
        if (move_uploaded_file($file['tmp_name'], $filePath)) {
            $cover_img_path = $filePath;
        } else {
            echo "Failed to upload the file.";
            exit();
        }
    }


    $cover_img_path_escaped = $cover_img_path ? mysqli_real_escape_string($conn, $cover_img_path) : null;
    $sql = "INSERT INTO properties (agent_id, name, description, address, price, map_latitude, map_longitude, cover_img, show_to_clients) 
    VALUES ('$agent_id', '$name', '$description', '$address', '$price', '$map_latitude', '$map_longitude', '$cover_img_path', '$show_to_clients')";

    if ($conn->query($sql) === TRUE) {
        header('Location: agent_dashboard.php');
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
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
            <div class="card">
                <div class="card-body">
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="form-floating mb-3">
                            <input type="text" name="name" id="c" class="form-control" required>
                            <label for="name">Property Name</label>
                        </div>
                        <div class="form-floating mb-3">
                            <textarea name="description" id="description" class="form-control" required></textarea>
                            <label for="description">Description</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="number" name="price" id="price" class="form-control" required>
                            <label for="price">Price</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" name="address" id="address" class="form-control" required>
                            <label for="address">Address</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" name="map_latitude" id="map_latitude" class="form-control">
                            <label for="map_latitude">Latitude</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" name="map_longitude" id="map_longitude" class="form-control">
                            <label for="map_longitude">Longitude</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="file" name="cover_img" class="form-control" id="cover_img">
                            <label for="cover_img">Cover Image</label>
                        </div>
                        <div class="form-floating mb-3">
                            <select name="show_to_clients" id="show_to_clients" class="form-control">
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>
                            <label for="show_to_clients">Show to Clients</label>
                        </div>
                        <button type="submit" class="btn btn-success">Create Property</button>
                    </form>
                </div>

            </div>
        </div>

    </main>

</body>

</html>