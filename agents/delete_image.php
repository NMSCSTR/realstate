<?php
session_start();
if (!isset($_SESSION['agent_id'])) {
    header('Location: login.php');
    exit();
}

$conn = mysqli_connect("localhost", "root", "", "oreep360");

if (isset($_POST['image_id']) && isset($_POST['image_path'])) {
    $image_id = intval($_POST['image_id']);
    $image_path = $_POST['image_path'];

    // Delete image from the database
    $query = "DELETE FROM property_images WHERE id = $image_id";
    $result = mysqli_query($conn, $query);

    if ($result) {
        // Delete image from the file system
        if (file_exists($image_path)) {
            unlink($image_path); // Delete the image file
        }
        echo 'success';
    } else {
        echo 'error';
    }
}
?>
