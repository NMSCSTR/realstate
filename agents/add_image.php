<?php
// Start the session to use session variables
session_start();

// Check if the 'agent_id' session variable is not set
if (!isset($_SESSION['agent_id'])) {
    // Redirect the user to the login page if not logged in
    header('Location: login.php');
    exit(); // Stop further execution of the script
}

// Establish a connection to the MySQL database
$conn = mysqli_connect("localhost", "root", "", "oreep360");

// Check if the 'property_id' parameter is provided in the URL
if (isset($_GET['property_id'])) {
    // Convert the 'property_id' parameter to an integer
    $property_id = intval($_GET['property_id']);
    // Query the database to retrieve the property details for the given ID
    $query = "SELECT * FROM properties WHERE property_id = $property_id";
    $result = mysqli_query($conn, $query);

    // Check if the query was successful and returned at least one row
    if ($result && mysqli_num_rows($result) > 0) {
        // Fetch the property data as an associative array
        $row = mysqli_fetch_assoc($result);
    } else {
        // Terminate the script with an error message if no property is found
        die("Property not found.");
    }
} else {
    // Terminate the script with an error message if no property ID is provided
    die("No property ID provided.");
}

// Handle image upload if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if any images are selected for upload
    if (!empty($_FILES['images']['name'][0])) {
        // Define the base directory for property image uploads
        $base_dir = '../uploads/property_image_compilation/';
        // Define the directory specific to the property ID
        $property_dir = $base_dir . $property_id . '/';

        // Create the directory for the property if it doesn't already exist
        if (!is_dir($property_dir)) {
            mkdir($property_dir, 0777, true);
        }

        // Loop through all uploaded images
        foreach ($_FILES['images']['tmp_name'] as $index => $tmp_name) {
            // Get the original file name of the uploaded image
            $file_name = basename($_FILES['images']['name'][$index]);
            // Generate a unique file path by appending a unique ID to the file name
            $file_path = $property_dir . uniqid() . '_' . $file_name;

            // Move the uploaded file to the designated file path
            if (move_uploaded_file($tmp_name, $file_path)) {
                // Insert the image path into the database for the associated property
                $query = "INSERT INTO property_images (property_id, image_path) VALUES ($property_id, '$file_path')";
                mysqli_query($conn, $query);
            }
        }
        // Notify the user that the images were uploaded successfully
        echo "Images uploaded successfully!";
    } else {
        // Notify the user if no files were selected for upload
        echo "No files selected.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADD IMAGES</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">

    <!-- DataTables Responsive CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.0/css/responsive.dataTables.min.css">

    <style>
    .card-img-container {
        position: relative;
        width: 100%;
        height: 200px;
    }

    .card-img-container img {
        object-fit: cover;
        width: 100%;
        height: 100%;
    }

    .delete-btn {
        position: absolute;
        top: 5px;
        right: 5px;
        background: rgba(0, 0, 0, 0.5);
        color: white;
        border: none;
        border-radius: 50%;
        font-size: 16px;
        padding: 5px;
        cursor: pointer;
    }

    .delete-btn:hover {
        background: rgba(255, 0, 0, 0.7);
    }
    </style>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg bg-body-tertiary shadow">
            <div class="container">
                <a class="navbar-brand" href="#">ONLINE REAL ESTATE ECOMMERCE PLATFORM</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText"
                    aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarText">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item"><a class="nav-link" href="index.php">HOME</a></li>
                        <li class="nav-item"><a class="nav-link" href="realestate.php">REAL STATES</a></li>
                        <li class="nav-item"><a class="nav-link active" href="agent.php">AGENTS</a></li>
                        <li class="nav-item"><a class="nav-link" href="account.php">ACCOUNT</a></li>
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
                <h5>ADD IMAGES FOR <span class="text-success text-bolder"><?= $row['name'] ?></span></h5>
                <a href="agent_dashboard.php" class="btn btn-secondary btn-sm mb-3">Back</a>
            </div>
            <hr>
            <!-- Form for adding images -->
            <form action="" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="formFileMultiple" class="form-label">Add Multiple Images</label>
                    <input class="form-control" type="file" id="formFileMultiple" name="images[]" multiple>
                </div>
                <button type="submit" class="btn btn-primary">Upload</button>
            </form>

            <!-- Display uploaded images in Bootstrap cards -->
            <div id="display_selected_images" class="mt-5">
                <h6>Uploaded Images</h6>
                <div class="row">
                    <?php
                    $images_query = "SELECT * FROM property_images WHERE property_id = $property_id";
                    $images_result = mysqli_query($conn, $images_query);
                    //Loop images after adding it
                    if ($images_result && mysqli_num_rows($images_result) > 0) {
                        while ($image_row = mysqli_fetch_assoc($images_result)) {
                            $image_path = $image_row['image_path'];
                            $image_id = $image_row['id'];
                            echo '<div class="col-md-3 mb-3">';
                            echo '<div class="card">';
                            echo '<div class="card-img-container">';
                            echo '<img src="' . $image_path . '" class="card-img-top" alt="Property Image">';
                            echo '<button class="delete-btn" onclick="deleteImage(' . $image_id . ', \'' . $image_path . '\')">X</button>';
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                        }
                    } else {
                        echo '<p>No images uploaded yet.</p>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </main>

    <script src="../bootstrap/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function deleteImage(imageId, imagePath) {
            // Prompt the user with a confirmation dialog
            if (confirm('Are you sure you want to delete this image?')) {
                // If the user confirms, make an AJAX request
                $.ajax({
                    // Specify the server-side script to handle the deletion
                    url: 'delete_image.php',
                    // Set the HTTP method for the request
                    method: 'POST',
                    // Include the data to be sent to the server (image ID and path)
                    data: {
                        image_id: imageId, // ID of the image to be deleted
                        image_path: imagePath // Path of the image file
                    },
                    // Callback function executed on successful AJAX request
                    success: function(response) {
                        // Check if the server response indicates success
                        if (response === 'success') {
                            // Notify the user that the image was deleted successfully
                            alert('Image deleted successfully');
                            // Reload the page to reflect the changes
                            location.reload();
                        } else {
                            // Notify the user if there was an error deleting the image
                            alert('Error deleting image');
                        }
                    },
                    // Callback function executed if the AJAX request fails
                    error: function() {
                        // Notify the user about an error during the deletion process
                        alert('An error occurred while deleting the image.');
                    }
                });
            }
        }
    </script>
</body>

</html>