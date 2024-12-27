<?php
// Start the session to access session variables
session_start();

// Check if the 'user_id' session variable is not set
if (!isset($_SESSION['user_id'])) {
    // Redirect the user to the login page if they are not logged in
    header('Location: login.php');
    exit(); // Stop further script execution
}

// Establish a connection to the MySQL database
$conn = mysqli_connect("localhost", "root", "", "oreep360");

// Query to get the next auto-increment value for the 'agents' table
$sql = "SELECT AUTO_INCREMENT FROM information_schema.tables WHERE table_name = 'agents' AND table_schema = 'oreep360'";

// Execute the query and store the result
$result = mysqli_query($conn, $sql);

// Fetch the next auto-increment value from the query result
$row = mysqli_fetch_assoc($result);

// Retrieve the next auto-increment value for the 'agents' table
$next_agent_id = $row['AUTO_INCREMENT'];

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
        <div class="container mt-4">
            <div class="d-flex justify-content-between w-100">
                <h5>Agent</h5>
                <button class="btn btn-success" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">Add new
                    agent</button>
            </div>
            <hr>
            <!-- Table for displaying all agents -->
            <div class="table-responsive mb-3">
                <table id="myTable" class="display responsive nowrap  caption-top">
                    <caption>List of Agents</caption>
                    <thead>
                        <tr>
                            <th>Profile</th>
                            <th>Agent Id</th>
                            <th>Full Name</th>
                            <th>Contact No.</th>
                            <th>Email Address</th>
                            <th>1st Verification</th>
                            <th>registration Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $conn = mysqli_connect("localhost", "root", "", "oreep360");

                        if (!$conn) {
                            die("Connection failed: " . mysqli_connect_error());
                        }
                        // Select query for getting all agents stored sa database
                        $sql = "SELECT * FROM agents";
                        $result = mysqli_query($conn, $sql);

                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr>
                            <td><img src='../<?php echo $row['profile_img']; ?>' alt='Profile Image' width='50'
                                    height='50' style='border-radius: 50%;'></td>
                            <td><?php echo $row['agent_id']; ?></td>
                            <td><?php echo $row['fullname']; ?></td>
                            <td><?php echo $row['contact_no']; ?></td>
                            <td><?php echo $row['email_address']; ?></td>
                            <td>
                                
                                <?php
                                if ($row['1st_verification'] === 'Verified') {
                                    echo $row['1st_verification']; 
                                }
                                 
                                 ?>
                            </td>
                            <td><?php echo $row['registration_date']; ?></td>
                            <td>
                                <a href='edit_agent.php?agent_id=<?php echo $row['agent_id']; ?>'>Edit</a> |
                                <a onclick="return confirm('are you sure you want to delete this agent?')"
                                    href='../controller/user/delete_agent.php?agent_id=<?php echo $row['agent_id']; ?>'>Delete</a>|
                                <a onclick="return confirm('are you sure you want to verified this agent?')" href='../controller/user/verified_agent.php?agent_id=<?php echo $row['agent_id']; ?>'>Verified Agent</a>
                            </td>
                        </tr>
                        <?php
                            }
                        } else {
                            echo "<tr><td colspan='9'>No users found</td></tr>";
                        }

                        mysqli_close($conn);
                        ?>
                    </tbody>

                </table>
            </div>

            <!-- Add Agent Collapse -->
            <div class="collapse" id="collapseExample">
                <h4>Add Agent</h4>
                <div class="card card-body">
                    <form action="../controller/user/add_agent.php" method="post" enctype="multipart/form-data">
                        <div class="form-floating mb-3">
                            <?php $agent_id = rand(10000, 99999); ?>
                            <input type="text" class="form-control" name="agent_id" value="<?php echo $agent_id ?>"
                                id="floatingInput" placeholder="Agent ID" required>
                            <label for="floatingInput">Agent Id</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="fullname" id="floatingInput"
                                placeholder="Full Name" required>
                            <label for="floatingInput">Full Name</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="contact" id="floatingInput"
                                placeholder="Full Name" required>
                            <label for="floatingInput">Contact #</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" name="email_address" id="floatingInput"
                                placeholder="Email Address" required>
                            <label for="floatingInput">Email Address</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" name="password" id="floatingPassword"
                                placeholder="Password" required>
                            <label for="floatingPassword">Password</label>
                        </div>
                        <button type="submit" class="btn btn-primary">Add Agent</button>
                    </form>
                </div>

            </div>

        </div>
    </main>

    <script src="../bootstrap/js/bootstrap.min.js"></script>
    <script>
    $(document).ready(function() {
        $('#myTable').DataTable({
            responsive: true
        });
    });
    </script>
</body>

</html>