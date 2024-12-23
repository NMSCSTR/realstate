<?php
session_start();
// database connection
$conn = mysqli_connect("localhost", "root", "", "oreep360"); 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data from front end
    $account_name = $_POST['account_name'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $user_type = $_POST['user_type'];

    // Validate the form data
    if (empty($account_name) || empty($username) || empty($password) || empty($user_type)) {
        echo "Please fill in all fields.";
    } else {

        // Check if the username already exists or already registered
        $check_username_query = "SELECT * FROM users WHERE username = '$username'";
        $check_result = mysqli_query($conn, $check_username_query);

        if (mysqli_num_rows($check_result) > 0) {
            // display error message
            echo "Username already taken. Please choose another one.";
        } else {
            // if not already registered Insert the new user into the database
            $insert_query = "INSERT INTO users (account_name, username, password, user_type) 
                            VALUES ('$account_name', '$username', '$password', '$user_type')";
            // E check niya kung success atung execution sa atung query
            if (mysqli_query($conn, $insert_query)) {
                header('Location: ../../admin/account.php'); 
                exit();
            } else {
                echo "Error adding user: " . mysqli_error($conn);
            }
        }
    }
}
?>
