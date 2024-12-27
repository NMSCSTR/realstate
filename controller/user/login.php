<?php
session_start();

$conn = mysqli_connect("localhost", "root", "", "oreep360");

if (isset($_POST['login'])) { 

    $username = $_POST['username'];
    $password = $_POST['password'];

    // login query
    $query = mysqli_query($conn,"SELECT * FROM users WHERE username = '$username' AND password = '$password'");
    // kuhaon ang data nga nag match sa query
    $row = mysqli_fetch_assoc($query);
    //iphon kung pila ang nag match
    $count = mysqli_num_rows($query);

    // if ang result kay naa 
    if ($count > 0) {
        $_SESSION['loggedin'] = "OK";
        // e stored nato sa session ang mga data gkan sa database for specific user gkan na sa database ang mga data like user_id,username,account_name
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
