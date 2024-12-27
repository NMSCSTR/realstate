<?php
// Establish a connection to the MySQL database
$conn = mysqli_connect("localhost", "root", "", "oreep360");

// Retrieve the 'id' (amenity ID) from the URL parameter
$id = $_GET['id'];
// Retrieve the 'property_id' from the URL parameter
$property_id = $_GET['property_id'];

// SQL query to delete the amenity record with the specified ID
$delete = "DELETE FROM `property_amenities` WHERE amenity_id = '$id'";
$result = mysqli_query($conn, $delete);

// Check if the deletion query was successful
if ($result) {
    // Redirect the user to the 'add_amenities.php' page with the 'property_id' parameter
    header("Location: add_amenities.php?property_id=" . urlencode($property_id));
    exit(); // Stop further script execution
} else {
    // Display an error message if the deletion query failed
    echo "Error deleting record: " . mysqli_error($conn);
}

// Close the database connection
mysqli_close($conn);
?>

