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
            <div class="row">
                <div class="card text-center">
                    <div class="card-header">
                        <ul class="nav nav-tabs card-header-tabs">
                            <li class="nav-item">
                                <a class="nav-link" aria-current="true" href="account.php">Profile</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" href="change_password.php">Change Password</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link"  href="add_user.php">Add User</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <form action="../controller/user/change_password.php" method="post">
                            <div class="form-floating mb-3">
                                <input type="password" class="form-control" name="old_password" id="floatingInput"
                                    placeholder="Old Password">
                                <label for="floatingInput">Old Password</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="password" class="form-control" name="new_password" id="floatingInput"
                                    placeholder="New Password">
                                <label for="floatingInput">New Password</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="password" class="form-control" name="retype_password" id="floatingPassword"
                                    placeholder="Retype New Password">
                                <label for="floatingPassword">Retype New Password</label>
                            </div>
                            <button class="btn btn-danger" type="button"
                                onclick="window.location.href='cancel_url.php';">Cancel</button>
                            <button class="btn btn-primary" type="submit">Change Password</button>
                        </form>
                    </div>
                </div>
            </div>

    </main>
    <script src="../bootstrap/js/bootstrap.min.js"></script>
</body>

</html>