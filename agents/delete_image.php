<?php
// Start the session to use session variables
session_start();

// Check if the 'agent_id' session variable is not set
if (!isset($_SESSION['agent_id'])) {
    // Redirect the user to the login page if they are not logged in
    header('Location: login.php');
    exit(); // Stop further script execution
}

// Establish a connection to the MySQL database
$conn = mysqli_connect("localhost", "root", "", "oreep360");

// Check if both 'image_id' and 'image_path' are provided in the POST request
if (isset($_POST['image_id']) && isset($_POST['image_path'])) {
    // Sanitize and store the image ID as an integer
    $image_id = intval($_POST['image_id']);
    // Store the image path from the POST request
    $image_path = $_POST['image_path'];

    // SQL query to delete the image record from the database
    $query = "DELETE FROM property_images WHERE id = $image_id";
    $result = mysqli_query($conn, $query);

    // Check if the database deletion was successful
    if ($result) {
        // Check if the image file exists on the server
        if (file_exists($image_path)) {
            // Delete the image file from the file system
            unlink($image_path);
        }
        // Respond with a success message
        echo 'success';
    } else {
        // Respond with an error message if the database query failed
        echo 'error';
    }
}
?>
