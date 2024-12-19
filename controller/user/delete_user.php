<?php
session_start();

$conn = mysqli_connect("localhost", "root", "", "oreep360");

if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];

    $delete_sql = "DELETE FROM users WHERE user_id = $user_id";
    if (mysqli_query($conn, $delete_sql)) {
        echo "User deleted successfully!";
        header("Location: ../../admin/account.php"); 
    } else {
        echo "Error deleting user. Please try again.";
    }
} else {
    echo "Invalid request.";
    exit();
}

// Close the connection
mysqli_close($conn);
?>
