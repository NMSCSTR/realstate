<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Real Estate</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
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

.property-card {
    margin-bottom: 1rem;
}

@media (max-width: 768px) {
    .property-card {
        width: 100%;
    }
}
</style>

<body>
    <header>
        <nav class="navbar navbar-expand-lg bg-body-tertiary shadow">
            <div class="container-md">
                <a class="navbar-brand" href="#" id="site-title">ONLINE REAL ESTATE ECOMMERCE PLATFORM</a>
                <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas"
                    data-bs-target="#staticBackdrop" aria-controls="staticBackdrop">
                    <i class="bi bi-box-arrow-in-right"></i> Login
                </button>
            </div>
        </nav>
    </header>
    <!-- Login -->
    <div class="offcanvas offcanvas-end" data-bs-backdrop="static" tabindex="-1" id="staticBackdrop"
        aria-labelledby="staticBackdropLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="staticBackdropLabel">Login</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <div>
                <form action="controller/user/login.php" method="post">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="username" id="floatingInput"
                            placeholder="johndoe">
                        <label for="floatingInput">Username</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" name="password" id="floatingPassword"
                            placeholder="Password">
                        <label for="floatingPassword">Password</label>
                    </div>
                    <div class="d-grid gap-2">
                        <span>Don't have an account? <a href="" data-bs-toggle="offcanvas" data-bs-target="#signup"
                                aria-controls="staticBackdrop">Create Now</a></span>
                        <button type="submit" class="btn btn-primary btn-block" name="login">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Sign Up -->
    <div class="offcanvas offcanvas-end" data-bs-backdrop="static" tabindex="-1" id="signup"
        aria-labelledby="staticBackdropLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="staticBackdropLabel">Sign up</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <div>
                <form action="controller/user/register.php" method="post">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="username" id="floatingInput" placeholder="">
                        <label for="floatingInput">Username</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" name="password" class="form-control" id="floatingPassword"
                            placeholder="Password">
                        <label for="floatingPassword">Password</label>
                    </div>
                    <div class="form-floating mb-3">
                        <select name="role" class="form-control" id="floatingRole">
                            <option value="user">User</option>
                            <option value="admin">Admin</option>
                        </select>
                        <label for="floatingRole">Role</label>
                    </div>
                    <div class="d-grid gap-2">
                        <span>Have an account? <a href="" data-bs-toggle="offcanvas" data-bs-target="#staticBackdrop"
                                aria-controls="staticBackdrop">Login Now</a></span>
                        <button type="submit" class="btn btn-primary btn-block">Register</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <!-- Modal for agent login -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Agent Login</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="controller/user/agentlogin.php" method="post">
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" name="email_address" id="floatingInput"
                                placeholder="johndoe" required>
                            <label for="floatingInput">Email Address</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" name="agent_password" id="floatingPassword"
                                placeholder="Password" required>
                            <label for="floatingPassword">Password</label>
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-block" name="agent_login">Login</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <main>
        <div class="container mt-4">
            <p>Real Estate Properties</p>
            <a href="" class="btn btn-outline-primary border-0 float-end shadow mb-2" data-bs-toggle="modal"
                data-bs-target="#exampleModal">Agent Portal</a>
            <input type="text" class="form-control" id="quickSearch" placeholder="Quick search">
        </div>
        <div class="container mt-4 d-sm-flex flex-wrap gap-2" id="propertyList">
            <?php
        $conn = mysqli_connect("localhost", "root", "", "oreep360");
        $sql = "SELECT property_id, name, address, cover_img FROM properties WHERE show_to_clients = 'Yes'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
        ?>
            <div class="card property-card" style="width: 18rem; margin: 1rem;"
                data-name="<?php echo htmlspecialchars($row['name']); ?>"
                data-address="<?php echo htmlspecialchars($row['address']); ?>">
                <img src="<?php echo htmlspecialchars($row['cover_img']); ?>" class="card-img-top w-100"
                    style="height: 200px; object-fit: cover;" alt="<?php echo htmlspecialchars($row['name']); ?>">
                <div class="card-body">
                    <h5 class="card-title"><?php echo htmlspecialchars($row['name']); ?></h5>
                    <p><i class="bi bi-geo-alt"></i> <?php echo htmlspecialchars($row['address']); ?></p>
                    <a href="view.php?id=<?php echo htmlspecialchars($row['property_id']); ?>"
                        class="btn btn-outline-primary">
                        <i class="bi bi-eye"></i> View Details
                    </a>
                </div>
            </div>
            <?php
            }
        } else {
            echo "<p>No properties available to show.</p>";
        }
        mysqli_close($conn);
        ?>
        </div>
    </main>


    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script>
    document.getElementById('quickSearch').addEventListener('input', function() {
        const searchValue = this.value.toLowerCase(); // Get the search input and convert to lowercase
        const propertyCards = document.querySelectorAll('.property-card'); // Get all property cards
        let matchesFound = false; // Track if any matches are found

        propertyCards.forEach(card => {
            const propertyName = card.dataset.name.toLowerCase(); // Get the name of the property
            const propertyAddress = card.dataset.address
        .toLowerCase(); // Get the address of the property

            // Show/hide the card based on whether it matches the search query
            if (propertyName.includes(searchValue) || propertyAddress.includes(searchValue)) {
                card.style.display = 'block'; // Show matching cards
                matchesFound = true; // Mark a match
            } else {
                card.style.display = 'none'; // Hide non-matching cards
            }
        });

        // Check if no matches are found
        const noResultsMessage = document.getElementById('noResultsMessage');
        if (!matchesFound) {
            if (!noResultsMessage) {
                // Add the message if it doesn't already exist
                const message = document.createElement('p');
                message.id = 'noResultsMessage';
                message.className = 'text-center text-muted mt-4';
                message.innerText = 'No properties found.';
                document.getElementById('propertyList').appendChild(message);
            }
        } else {
            // Remove the "No properties found" message if matches are found
            if (noResultsMessage) {
                noResultsMessage.remove();
            }
        }
    });
    </script>



</body>

</html>