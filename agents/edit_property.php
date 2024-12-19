<?php
session_start();
if (!isset($_SESSION['agent_id'])) {
    header('Location: login.php');
    exit();
}
$conn = mysqli_connect("localhost", "root", "", "oreep360");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $property_id = $_POST['property_id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $address = $_POST['address'];
    $price = $_POST['price'];
    $map_latitude = $_POST['map_latitude'];
    $map_longitude = $_POST['map_longitude'];
    $cover_img = $_POST['cover_img'];
    $show_to_clients = $_POST['show_to_clients'];

    $sql = "UPDATE properties SET name='$name', description='$description', address='$address', price='$price', 
            map_latitude='$map_latitude', map_longitude='$map_longitude', cover_img='$cover_img', 
            show_to_clients='$show_to_clients' WHERE property_id=$property_id";

    if ($conn->query($sql) === TRUE) {
        header('Location: index.php');
        exit(); 
        echo "Error: " . $conn->error;
    }
}

if (isset($_GET['id'])) {
    $property_id = $_GET['id'];
    $sql = "SELECT * FROM properties WHERE property_id=$property_id";
    $result = $conn->query($sql);
    $property = $result->fetch_assoc();
} else {
    echo "Property not found!";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Property</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <div class="container mt-5">
        <h1 class="mb-4">Edit Property</h1>

        <form action="edit_property.php" method="POST">
            <input type="hidden" name="property_id" value="<?= $property['property_id']; ?>">

            <div class="mb-3">
                <label for="name" class="form-label">Property Name</label>
                <input type="text" name="name" id="name" class="form-control" value="<?= $property['name']; ?>"
                    required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" id="description" class="form-control"
                    required><?= $property['description']; ?></textarea>
            </div>

            <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <input type="number" name="price" id="price" class="form-control" value="<?= $property['price']; ?>"
                    required>
            </div>

            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <input type="text" name="address" id="address" class="form-control" value="<?= $property['address']; ?>"
                    required>
            </div>

            <div class="mb-3">
                <label for="map_latitude" class="form-label">Latitude</label>
                <input type="text" name="map_latitude" id="map_latitude" class="form-control"
                    value="<?= $property['map_latitude']; ?>">
            </div>

            <div class="mb-3">
                <label for="map_longitude" class="form-label">Longitude</label>
                <input type="text" name="map_longitude" id="map_longitude" class="form-control"
                    value="<?= $property['map_longitude']; ?>">
            </div>

            <div class="mb-3">
                <label for="cover_img" class="form-label">Cover Image</label>
                <input type="text" name="cover_img" id="cover_img" class="form-control"
                    value="<?= $property['cover_img']; ?>">
            </div>

            <div class="mb-3">
                <label for="show_to_clients" class="form-label">Show to Clients</label>
                <select name="show_to_clients" id="show_to_clients" class="form-control">
                    <option value="Yes" <?= $property['show_to_clients'] == 'Yes' ? 'selected' : ''; ?>>Yes</option>
                    <option value="No" <?= $property['show_to_clients'] == 'No' ? 'selected' : ''; ?>>No</option>
                </select>
            </div>

            <button type="submit" class="btn btn-warning">Update Property</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>

</html>