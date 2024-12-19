<?php 
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Connect to the database
$conn = mysqli_connect("localhost", "root", "", "oreep360");

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get user_id from the URL
if (isset($_GET['agent_id'])) {
    $agent_id = $_GET['agent_id'];

    // Fetch the user data from the database
    $sql = "SELECT * FROM agents WHERE agent_id = $agent_id";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
    } else {
        echo "Agent not found.";
        exit();
    }
} else {
    echo "Invalid request.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $agent_id = $_POST['agent_id'] ?? '';
    $fullname = $_POST['fullname'] ?? '';
    $contact_no = $_POST['contact_no'] ?? '';
    $email_address = $_POST['email_address'] ?? '';
    $password = $_POST['password'] ?? '';


    $update_sql = "UPDATE `agents` SET `fullname`='$fullname',`contact_no`='$contact_no',`email_address`='$email_address',`password`='$password' WHERE agent_id = $agent_id";

    if (mysqli_query($conn, $update_sql)) {
        echo "Agent details updated successfully!";
        header("Location: agent.php");
        exit();
    } else {
        echo "Error updating user. Please try again.";
    }
    
}

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
    const showPasswordCheckbox = document.getElementById('flexCheckDefault');
    const show_pass = document.getElementById('floatingPassword');

    showPasswordCheckbox.addEventListener('change', () => {
        if (showPasswordCheckbox.checked) {
            show_pass.type = 'text';
        } else {
            show_pass.type = 'password';
        }
    })
    </script>
</body>

</html>