<?php
session_start();
// db connection
$conn = mysqli_connect("localhost", "root", "", "oreep360");

// http://www.agent.php?agent_id=4 
if (isset($_GET['agent_id'])) {
    $agent_id = $_GET['agent_id']; //stored 4
    // delete agent
    $delete_sql = "DELETE FROM agents WHERE agent_id = $agent_id";
    if (mysqli_query($conn, $delete_sql)) {
        header("Location: ../../admin/agent.php"); 
    } else {
        echo "Error deleting agent. Please try again.";
    }
} else {
    echo "Invalid request.";
    exit();
}

mysqli_close($conn);
?>
