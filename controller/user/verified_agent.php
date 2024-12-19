<?php

$conn = mysqli_connect("localhost", "root", "", "oreep360");

if (isset($_GET['agent_id'])) {

    $agent_id = $_GET['agent_id'];

    $sql = "UPDATE `agents` SET `1st_verification`='Verified' WHERE agent_id='$agent_id'";

    if (mysqli_query($conn, $sql)) {
        echo "Agent verified successfully.";
        header('Location: ../../admin/agent.php');
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
    mysqli_close($conn);
}
?>
