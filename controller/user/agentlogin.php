<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "oreep360");

if (isset($_POST['agent_login'])) {
    $email_address = $_POST['email_address'];
    $password = $_POST['agent_password'];

    $query = mysqli_query($conn,"SELECT * FROM agents WHERE email_address = '$email_address' AND password = '$password'"
);
    $row = mysqli_fetch_assoc($query);
    $count = mysqli_num_rows($query);
    
    if ($count > 0) {
        $_SESSION['isLoggedin'] = "OK";
        $_SESSION['agent_id'] = $row['agent_id'];
        $_SESSION['fullname'] = $row['fullname'];
        $_SESSION['contact_no'] = $row['contact_no'];
        $_SESSION['1st_verification'] = $row['1st_verification'];
        $_SESSION['2nd_verification'] = $row['2nd_verification'];
        header('location: ../../agents/agent_dashboard.php');
    } else {
        header('location: ../../index.php?error= Invalid email and password');
    }
    
}
?>
