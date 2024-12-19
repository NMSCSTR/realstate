<?php
session_start();

$conn = mysqli_connect("localhost", "root", "", "oreep360");

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = mysqli_query($conn,"SELECT * FROM users WHERE username = '$username' AND password = '$password'"
);
    $row = mysqli_fetch_assoc($query);
    $count = mysqli_num_rows($query);

    if ($count > 0) {
        $_SESSION['loggedin'] = "OK";
        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['account_name'] = $row['account_name'];
        $_SESSION['user_type'] = $row['user_type'];
        header('location: ../../admin/index.php?status = success');
    } else {
        header('location: ../../index.php?error= Invalid username and password');
    }
    
}
?>
