<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
$conn = mysqli_connect("localhost", "root", "", "oreep360");
$query = mysqli_query($conn,"SELECT * FROM agents");
$row = mysqli_fetch_assoc($query);
$count = mysqli_num_rows($query);
$query1 = mysqli_query($conn,"SELECT * FROM properties");
$row1 = mysqli_fetch_assoc($query1);
$count1 = mysqli_num_rows($query1);

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
                            <a class="nav-link active" aria-current="page" href="#">HOME</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="realestate.php">REAL STATES</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="agent.php">AGENTS</a>
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
            <h6>Welcome, <strong><?php echo $_SESSION['account_name'] ?></strong></h6>
            <div class="row">
                <div class="col-sm-6">
                    <div class="card text-bg-light mt-4 bg-transparent">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $count1 ?></</h5>
                            <p class="card-text">Real Estate Properties</p>
                            <a href="realestate.php" class="btn btn-warning">View</a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="card text-bg-light mt-4 bg-transparent">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $count ?></h5>
                            <p class="card-text">Fully Verified Agents</p>
                            <a href="agent.php" class="btn btn-warning">View</a>
                        </div>
                    </div>
                </div>
            </div>

            <h5 class="mt-4">Logs</h5>
            <hr>
            <div class="border bg-white">
                <div class="d-flex align-items-center p-2">
                    <div class="border rounded-circle overflow-hidden me-2" style="height: 2rem; width: 2rem;">
                        <img src="https://oreep360.com/assets/images/unknown.png" class="img-fluid h-100 w-100">
                    </div>
                    <strong class="me-auto">John Doe</strong>
                    <small class="text-secondary">28-Jun-2024 01:24 pm</small>
                </div>
                <div class="p-2">
                    Changing Password at <strong><?php echo date("Y-m-d")?></strong> <a class="text-primary"
                        href="https://oreep360.com/admin/real-estates/view.php?property_id=1719552268">View</a>
                </div>
            </div>


        </div>



    </main>

    <script src="../bootstrap/js/bootstrap.min.js"></script>



</body>

</html>