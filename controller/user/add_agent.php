<?php
// database connection
$conn = mysqli_connect("localhost", "root", "", "oreep360");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Data from front end
    $agent_id =  $_POST['agent_id']; 
    $fullname =$_POST['fullname'];
    $contact = $_POST['contact'];
    $email_address = $_POST['email_address'];
    $password = $_POST['password'];

    // Set default values for the unverified columns
    $first_verification = 'Unverified';
    $second_verification = 'Unverified';
    $registration_date = date('Y-m-d H:i:s'); // Get the current date and time
    $profile_img = 'assets/images/unknown.png'; // Default profile image

    // SQL query to insert the new agent into the database
    $sql = "INSERT INTO agents (agent_id, fullname, contact_no, email_address, password, 1st_verification, 2nd_verification, registration_date, profile_img) 
            VALUES ('$agent_id', '$fullname', '$contact', '$email_address', '$password', '$first_verification', '$second_verification', '$registration_date', '$profile_img')";

    if (mysqli_query($conn, $sql)) {
        // redirect back to agent after successful insertion
        header('Location: ../../admin/agent.php');
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    // Close the connection
    mysqli_close($conn);
}
?>
