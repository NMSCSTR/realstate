<?php
// database connection
$conn = mysqli_connect("localhost", "root", "", "oreep360");
// check if there is an agent id has pass in the url parameter
if (isset($_GET['agent_id'])) {

    $agent_id = $_GET['agent_id']; //store the id

    $sql = "UPDATE `agents` SET `1st_verification`='Verified' WHERE agent_id='$agent_id'"; //update query 

    if (mysqli_query($conn, $sql)) {
        echo "Agent verified successfully.";
        header('Location: ../../admin/agent.php');
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
    mysqli_close($conn);
}
?>
