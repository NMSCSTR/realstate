<?php 
session_start(); 
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Real Estate</title>
    <link rel="stylesheet" href="style.css">
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
                            <a class="nav-link active" href="realestate.php">REAL STATES</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="agent.php">AGENTS</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="#">ACCOUNT</a>
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
            <h5>Account</h5>
            <hr>
            <!-- User details -->
            <div class="row mb-3">
                <div class="card text-center">
                    <div class="card-header">
                        <ul class="nav nav-tabs card-header-tabs">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="true" href="account.php">Profile</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="change_password.php">Change Password</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="add_user.php">Add User</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <img src="https://cdn-icons-png.flaticon.com/512/149/149071.png" class="img-fluid mb-3"
                            alt="user-icon" width="250">
                        <h5><strong>User Id: </strong><?php echo $_SESSION['user_id'] ?></h5>
                        <h5 class="card-title mt-3"><strong>Account Name:
                            </strong><?php echo $_SESSION['account_name'] ?></h5>
                        <h5 class="card-title mt-3"><strong>User Type: </strong><?php echo $_SESSION['user_type'] ?>
                        </h5>
                    </div>
                </div>
            </div>
            <!-- Table for displaying info -->
            <div class="table-responsive">
                <table id="myTable" class="display responsive nowrap  caption-top">
                    <caption>List of users</caption>
                    <thead>
                        <tr>
                            <th>User Id</th>
                            <th>Account Name</th>
                            <th>Username</th>
                            <th>User Type</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $conn = mysqli_connect("localhost", "root", "", "oreep360");
                            $sql = "SELECT * FROM users";
                            $result = mysqli_query($conn, $sql);

                            if (mysqli_num_rows($result) > 0) {

                                // display users info
                                while ($row = mysqli_fetch_assoc($result)) { ?>
                                    <tr>
                                    <td><?php echo $row['user_id'] ?> </td>
                                    <td><?php echo $row['account_name'] ?> </td>
                                    <td><?php echo $row['username'] ?> </td>
                                    <td><?php echo $row['user_type'] ?> </td>
                                    
                                    <td>   
                                        <a class="btn btn-primary btn-sm" href='edit_user.php?user_id=" . $row['user_id'] . "'>Edit</a> 
                                        <?php echo ($row['user_type'] !== 'admin') ? "| <a class='btn btn-danger btn-sm' href='../controller/user/delete_user.php?user_id=" . $row['user_id'] . "'>Delete</a>" : ''; ?>        
                                        </td>
                                    </tr>
                                
                                    <?php
                                }
                            } else {
                                echo "<tr><td colspan='5'>No users found</td></tr>";
                            }

                            mysqli_close($conn);
                        ?>
                    </tbody>
                </table>
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