<?php
// Establish a connection to the MySQL database
$conn = mysqli_connect("localhost", "root", "", "oreep360");

// Check if the 'agent_id' is passed in the URL parameter
if (isset($_GET['agent_id'])) {

    // Retrieve the agent ID from the URL parameter and store it in a variable
    $agent_id = $_GET['agent_id'];

    // SQL query to update the agent's verification status in the database
    $sql = "UPDATE `agents` SET `1st_verification`='Verified' WHERE agent_id='$agent_id'";

    // Execute the query and check if it was successful
    if (mysqli_query($conn, $sql)) {
        // Display success message and redirect to the agent page
        echo "Agent verified successfully.";
        header('Location: ../../admin/agent.php');
    } else {
        // Display error message if the query fails
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    // Close the database connection
    mysqli_close($conn);
}
?>
