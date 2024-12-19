<?php 
$conn = mysqli_connect("localhost", "root", "", "oreep360");
$id = $_GET['id'];
$delete = "DELETE FROM `property_amenities` WHERE amenity_id = '$id'";
$result = mysqli_query($conn,$delete);

if ($result) {
    header('Location: add_aminities.php');
    exit();
}
?>