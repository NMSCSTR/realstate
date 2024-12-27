<?php
// Start the session to access session variables
session_start();

// Establish a connection to the MySQL database
$conn = mysqli_connect("localhost", "root", "", "oreep360");

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve the old, new, and retype password fields from the POST request
    $old_password = $_POST['old_password'] ?? ''; // Old password
    $new_password = $_POST['new_password'] ?? ''; // New password
    $retype_password = $_POST['retype_password'] ?? ''; // Retyped new password

    // Validate if all fields are filled
    if (empty($old_password) || empty($new_password) || empty($retype_password)) {
        echo "Please fill in all the fields."; // Prompt user to complete all fields
    } 
    // Check if the new password matches the retyped password
    elseif ($new_password !== $retype_password) {
        echo "New passwords do not match."; // Inform user of mismatch
    } else {
        // Retrieve the user ID from the session
        $user_id = $_SESSION['user_id'];

        // Query to fetch the current password of the user
        $result = mysqli_query($conn, "SELECT password FROM users WHERE user_id = $user_id");

        // Check if the query returned a result
        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result); // Fetch the user's data
            $current_password = $row['password']; // Current password from the database

            // Check if the provided old password matches the current password
            if ($old_password === $current_password) {
                // Query to update the user's password
                $update_query = "UPDATE users SET password = '$new_password' WHERE user_id = $user_id";

                // Execute the update query
                if (mysqli_query($conn, $update_query)) {
                    echo "Password updated successfully!"; // Success message
                    header('Location: ../../admin/account.php'); // Redirect to account page
                } else {
                    echo "Error updating password. Please try again."; // Error updating password
                }
            } else {
                echo "Old password is incorrect."; // Inform user of incorrect old password
            }
        } else {
            echo "User not found."; // Inform if user data is not found
        }
    }
}
?>
