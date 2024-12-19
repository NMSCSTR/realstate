<?php 
session_start();
$conn = mysqli_connect("localhost", "root", "", "oreep360");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $old_password = $_POST['old_password'] ?? '';
    $new_password = $_POST['new_password'] ?? '';
    $retype_password = $_POST['retype_password'] ?? '';

    if (empty($old_password) || empty($new_password) || empty($retype_password)) {
        echo "Please fill in all the fields.";
    } elseif ($new_password !== $retype_password) {
        echo "New passwords do not match.";
    } else {
        $user_id = $_SESSION['user_id'];
        
        $result = mysqli_query($conn, "SELECT password FROM users WHERE user_id = $user_id");

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $current_password = $row['password'];

            if ($old_password === $current_password) {
                $update_query = "UPDATE users SET password = '$new_password' WHERE user_id = $user_id";

                if (mysqli_query($conn, $update_query)) {
                    echo "Password updated successfully!";
                    header('Location: ../../admin/account.php');
                } else {
                    echo "Error updating password. Please try again.";
                }
            } else {
                echo "Old password is incorrect.";
            }
        } else {
            echo "User not found.";
        }
    }
}
?>