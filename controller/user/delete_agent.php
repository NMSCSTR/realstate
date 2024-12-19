<?php
session_start();

$conn = mysqli_connect("localhost", "root", "", "oreep360");

if (isset($_GET['agent_id'])) {
    $agent_id = $_GET['agent_id'];

    $delete_sql = "DELETE FROM agents WHERE agent_id = $agent_id";
    if (mysqli_query($conn, $delete_sql)) {
        echo "Agent deleted successfully!";
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
