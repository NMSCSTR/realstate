<?php
session_start();
// 
$conn = mysqli_connect("localhost", "root", "", "oreep360"); 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $account_name = mysqli_real_escape_string($conn, $_POST['account_name']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $user_type = mysqli_real_escape_string($conn, $_POST['user_type']);

    // Validate the form data
    if (empty($account_name) || empty($username) || empty($password) || empty($user_type)) {
        echo "Please fill in all fields.";
    } else {

        // Check if the username already exists
        $check_username_query = "SELECT * FROM users WHERE username = '$username'";
        $check_result = mysqli_query($conn, $check_username_query);

        if (mysqli_num_rows($check_result) > 0) {
            echo "Username already taken. Please choose another one.";
        } else {
            // Insert the new user into the database
            $insert_query = "INSERT INTO users (account_name, username, password, user_type) 
                            VALUES ('$account_name', '$username', '$password', '$user_type')";

            if (mysqli_query($conn, $insert_query)) {
                echo "New user added successfully!";
                header('Location: ../../admin/account.php'); 
                exit();
            } else {
                echo "Error adding user: " . mysqli_error($conn);
            }
        }
    }
}
?>
