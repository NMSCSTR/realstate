<?php
session_start();
if (!isset($_SESSION['agent_id'])) {
    header('Location: login.php');
    exit();
}

$conn = mysqli_connect("localhost", "root", "", "oreep360");

?>

<?php
include 'db.php';

if (isset($_GET['id'])) {
    $property_id = $_GET['id'];

    // Delete the property
    $sql = "DELETE FROM properties WHERE property_id = $property_id";

    if ($conn->query($sql) === TRUE) {
        header('Location: index.php');
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
} else {
    echo "No property ID provided!";
}
?>