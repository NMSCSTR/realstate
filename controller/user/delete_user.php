<?php
session_start();
// database connection
$conn = mysqli_connect("localhost", "root", "", "oreep360");

// e check if naa bay ge pasa nga id gkan sa url parameter
if (isset($_GET['user_id'])) { 
    // kung naay id e stored niya using the variable $user_id
    $user_id = $_GET['user_id'];
    // Delete query where the specific id pass by the url parameter has pass
    $delete_sql = "DELETE FROM users WHERE user_id = $user_id";
    // check if the query is successful
    if (mysqli_query($conn, $delete_sql)) {
        // if success redirect to the account.php in admin
        header("Location: ../../admin/account.php"); 
    } else {
        // error
        echo "Error deleting user. Please try again.";
    }
} else {
    echo "Invalid request.";
    exit();
}
// closing the connection
mysqli_close($conn);
?>
