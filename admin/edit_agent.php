<!-- code for updating agent -->
<?php 
// Start the session to access session variables
session_start();

// Check if the user is logged in by checking the 'user_id' session variable
if (!isset($_SESSION['user_id'])) {
    // If not logged in, redirect to the login page
    header('Location: login.php');
    exit(); // Stop the script from executing further
}

// Connect to the MySQL database
$conn = mysqli_connect("localhost", "root", "", "oreep360");

// Check if the database connection is successful
if (!$conn) {
    // If connection fails, output an error and stop the script
    die("Connection failed: " . mysqli_connect_error());
}

// Check if 'agent_id' is passed in the URL
if (isset($_GET['agent_id'])) {
    // Get the agent_id from the URL
    $agent_id = $_GET['agent_id'];

    // Query to fetch agent data from the database based on the agent_id
    $sql = "SELECT * FROM agents WHERE agent_id = $agent_id";
    $result = mysqli_query($conn, $sql);

    // If data is found, fetch it
    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result); // Store user data in the $user array
    } else {
        // If no agent is found, output an error message and stop the script
        echo "Agent not found.";
        exit();
    }
} else {
    // If 'agent_id' is not passed in the URL, output an error and stop the script
    echo "Invalid request.";
    exit();
}

// Check if the form is submitted (POST request)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve the form data using the POST method, or set it to empty if not provided
    $agent_id = $_POST['agent_id'] ?? '';
    $fullname = $_POST['fullname'] ?? '';
    $contact_no = $_POST['contact_no'] ?? '';
    $email_address = $_POST['email_address'] ?? '';
    $password = $_POST['password'] ?? '';

    // Prepare the SQL query to update the agent's details
    $update_sql = "UPDATE `agents` SET `fullname`='$fullname',`contact_no`='$contact_no',`email_address`='$email_address',`password`='$password' WHERE agent_id = $agent_id";

    // Execute the update query
    if (mysqli_query($conn, $update_sql)) {
        // If the update is successful, display a success message and redirect
        echo "Agent details updated successfully!";
        header("Location: agent.php"); // Redirect to the agent list page
        exit();
    } else {
        // If an error occurs while updating, display an error message
        echo "Error updating user. Please try again.";
    }
}

// Close the database connection
mysqli_close($conn);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Real Estate</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">

    <!-- DataTables Responsive CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.0/css/responsive.dataTables.min.css">

    <!-- jQuery (necessary for DataTables to work) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

    <!-- DataTables Responsive JS -->
    <script src="https://cdn.datatables.net/responsive/2.4.0/js/dataTables.responsive.min.js"></script>
</head>
<style>
@import url('https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap');

* {
    padding: 0;
    margin: 0;
}

body {
    font-family: "Montserrat", sans-serif;
}

#site-title {
    font-weight: 600;
}
</style>

<body>
    <header>
        <nav class="navbar navbar-expand-lg bg-body-tertiary shadow">
            <div class="container">
                <a class="navbar-brand" id="site-title" href="#">ONLINE REAL ESTATE ECOMMERCE PLATFORM</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText"
                    aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarText">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="index.php">HOME</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="realestate.php">REAL STATES</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="agent.php">AGENTS</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="account.php">ACCOUNT</a>
                        </li>
                    </ul>
                    <span class="navbar-text">
                        <a href="../logout.php" class="btn btn-danger text-white"
                            onclick="return confirm('Are you sure you want to logout?')">
                            <i class="bi bi-box-arrow-in-right"></i> Logout
                        </a>
                    </span>
                </div>
            </div>
        </nav>
    </header>

    <main>
        <div class="container mt-5">
            <form action="" method="post" enctype="multipart/form-data">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" name="agent_id" value="<?php echo $user['agent_id'] ?>"
                        id="floatingInput" placeholder="Agent ID" required readonly>
                    <label for="floatingInput">Agent Id</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" name="fullname" value="<?php echo $user['fullname'] ?>"
                        id="floatingInput" placeholder="Full Name" required>
                    <label for="floatingInput">Full Name</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" name="contact_no" value="<?php echo $user['contact_no'] ?>"
                        id="floatingInput" placeholder="Full Name" required>
                    <label for="floatingInput">Contact #</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="email" class="form-control" name="email_address"
                        value="<?php echo $user['email_address'] ?>" id="floatingInput" placeholder="Email Address"
                        required>
                    <label for="floatingInput">Email Address</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="password" class="form-control" name="password" value="<?php echo $user['password'] ?>"
                        id="floatingPassword" placeholder="Password" required>
                    <label for="floatingPassword">Password</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                    <label class="form-check-label mb-2" for="flexCheckDefault">
                        Show Password
                    </label>
                </div>

                <button type="submit" class="btn btn-primary">Add Agent</button>
            </form>
        </div>
    </main>


    <script src="../bootstrap/js/bootstrap.min.js"></script>

    <!-- kani para sa show/hide password -->
    <script>
    // Get the checkbox element with the id 'flexCheckDefault'
    const showPasswordCheckbox = document.getElementById('flexCheckDefault');

    // Get the password input field with the id 'floatingPassword'
    const show_pass = document.getElementById('floatingPassword');

    // Add an event listener to the checkbox that listens for a change in its state
    showPasswordCheckbox.addEventListener('change', () => {
        // If the checkbox is checked, change the input type to 'text' to show the password
        if (showPasswordCheckbox.checked) {
            show_pass.type = 'text';
        } else {
            // If the checkbox is unchecked, change the input type to 'password' to hide the password
            show_pass.type = 'password';
        }
    })
    </script>

</body>

</html>