<?php
// Start the session to use session variables
session_start();

// Check if the session variable 'agent_id' is not set
if (!isset($_SESSION['agent_id'])) {
    // Redirect the user to the login page if they are not logged in
    header('Location: login.php');
    exit(); // Stop further script execution
}

// Establish a connection to the MySQL database
$conn = mysqli_connect("localhost", "root", "", "oreep360");



// Check if the 'id' parameter is provided in the URL
if (isset($_GET['id'])) {
    // Get the property ID from the URL parameter
    $property_id = $_GET['id'];

    // SQL query to delete the property with the specified ID
    $sql = "DELETE FROM properties WHERE property_id = $property_id";

    // Execute the query and check if it was successful
    if ($conn->query($sql) === TRUE) {
        // Redirect the user to the index page after deletion
        header('Location: index.php');
        exit(); // Stop further script execution
    } else {
        // Display an error message if the query fails
        echo "Error: " . $conn->error;
    }
} else {
    // Display an error message if no property ID is provided in the URL
    echo "No property ID provided!";
}
?>
