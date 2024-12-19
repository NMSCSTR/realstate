<?php 
$conn = mysqli_connect("localhost", "root", "", "oreep360");

$id = $_GET['id'];
$property_id = $_GET['property_id'];

$delete = "DELETE FROM `property_amenities` WHERE amenity_id = '$id'";
$result = mysqli_query($conn, $delete);

if ($result) {
    header("Location: add_amenities.php?property_id=" . urlencode($property_id));
    exit();
} else {
    echo "Error deleting record: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
