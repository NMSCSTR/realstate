<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
$conn = mysqli_connect("localhost", "root", "", "oreep360");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize input to prevent SQL injection
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $role = isset($_POST['role']) ? mysqli_real_escape_string($conn, trim($_POST['role'])) : 'user'; // Default to 'user'

    // Check if username and password are provided
    if (!$username || !$password) {
        $_SESSION['error'] = "Please fill in all fields.";
        header("Location: ../../register.php");
        exit;
    }

    // Allowed roles check
    $allowed_roles = ['user', 'admin'];
    if (!in_array($role, $allowed_roles)) {
        $_SESSION['error'] = "Invalid role selected.";
        header("Location: ../../register.php");
        exit;
    }

    // Check if username already exists
    $query = "SELECT user_id FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $_SESSION['error'] = "Username is already taken.";
    } else {
        // Insert new user into the database
        $query = "INSERT INTO users (username, password, user_type) VALUES ('$username', '$password', '$role')";
        if (mysqli_query($conn, $query)) {
            $_SESSION['success'] = "Registration successful! Please log in.";
            mysqli_close($conn);
            header("Location: ../../index.php");
            exit;
        } else {
            $_SESSION['error'] = "Database error: " . mysqli_error($conn);
        }
    }
    mysqli_close($conn);
    header("Location: ../../register.php");
    exit;
}

header("HTTP/1.1 403 Forbidden");
exit;
?>
