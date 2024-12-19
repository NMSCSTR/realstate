<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $role = isset($_POST['role']) ? trim($_POST['role']) : 'user'; // Default to 'user'

    // Debugging output
    if (!$username || !$password) {
        die("Debug: Username or password is empty.");
    }

    // Allowed roles
    $allowed_roles = ['user', 'admin'];
    if (!in_array($role, $allowed_roles)) {
        die("Invalid role selected.");
    }

    // Check for duplicate username
    $query = "SELECT id FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $_SESSION['error'] = "Username is already taken.";
    } else {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert into database
        $query = "INSERT INTO users (username, password, role) VALUES ('$username', '$hashed_password', '$role')";
        if (mysqli_query($conn, $query)) {
            $_SESSION['success'] = "Registration successful! Please log in.";
            header("Location: ../../index.php");
            exit;
        } else {
            $_SESSION['error'] = "Database error: " . mysqli_error($conn);
        }
    }
    mysqli_close($conn);
    header("Location: ../../index.php");
    exit;
}

header("HTTP/1.1 403 Forbidden");
exit;
