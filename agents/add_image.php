<?php
session_start();
if (!isset($_SESSION['agent_id'])) {
    header('Location: login.php');
    exit();
}

$conn = mysqli_connect("localhost", "root", "", "oreep360");

if (isset($_GET['property_id'])) {
    $property_id = intval($_GET['property_id']);
    $query = "SELECT * FROM properties WHERE property_id = $property_id";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
    } else {
        die("Property not found.");
    }
} else {
    die("No property ID provided.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_FILES['images']['name'][0])) {
        $upload_dir = '../uploads/property_image_compilation/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        foreach ($_FILES['images']['tmp_name'] as $index => $tmp_name) {
            $file_name = basename($_FILES['images']['name'][$index]);
            $file_path = $upload_dir . uniqid() . '_' . $file_name;

            if (move_uploaded_file($tmp_name, $file_path)) {
                $query = "INSERT INTO property_images (property_id, image_path) VALUES ($property_id, '$file_path')";
                mysqli_query($conn, $query);
            }
        }
        echo "Images uploaded successfully!";
    } else {
        echo "No files selected.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADD IMAGES</title>
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
                        <button class="btn btn-danger" type="button" data-bs-toggle="offcanvas"
                            data-bs-target="#staticBackdrop" aria-controls="staticBackdrop">
                            <i class="bi bi-box-arrow-in-right"></i> Logout
                        </button>
                    </span>
                </div>
            </div>
        </nav>
    </header>

    <div class="container mt-4">
        <div class="d-flex justify-content-between w-100">
            <h5>ADD IMAGES FOR <span class="text-success text-bolder"><?= $row['name'] ?></span></h5>
            <a href="agent_dashboard.php" class="btn btn-secondary btn-sm mb-3">Back</a>
        </div>
        <hr>
        <!-- FORM FOR ADDING IMAGES -->
        <form action="" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="formFileMultiple" class="form-label">Add Multiple Images</label>
                <input class="form-control" type="file" id="formFileMultiple" name="images[]" multiple>
            </div>
            <button type="submit" class="btn btn-primary">Upload</button>
        </form>

        <div id="display_selected_images">
            <h6>Uploaded Images</h6>
            <div class="row">
                <?php
                $images_query = "SELECT * FROM property_images WHERE property_id = $property_id";
                $images_result = mysqli_query($conn, $images_query);

                if ($images_result && mysqli_num_rows($images_result) > 0) {
                    while ($image_row = mysqli_fetch_assoc($images_result)) {
                        echo '<div class="col-md-3 mb-3">';
                        echo '<img src="' . $image_row['image_path'] . '" class="img-thumbnail" alt="Property Image">';
                        echo '</div>';
                    }
                } else {
                    echo '<p>No images uploaded yet.</p>';
                }
                ?>
            </div>
        </div>
    </div>
    </main>
    <script src="../bootstrap/js/bootstrap.min.js"></script>

</body>

</html>