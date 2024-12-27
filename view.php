<?php
$property_id = $_GET['id'];
$conn = mysqli_connect("localhost", "root", "", "oreep360");

$sql = "SELECT * FROM properties WHERE property_id = '$property_id'";
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    $getprop = mysqli_fetch_assoc($result);
    $longitude = $getprop['map_longitude'];
    $latitude = $getprop['map_latitude'];
    $agent_id = $getprop['agent_id'];

    if (!isset($latitude) || !isset($longitude) || empty($latitude) || empty($longitude)) {
        $latitude = 0;
        $longitude = 0;
    }
} else {
    die("Property not found or invalid property_id.");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Real Estate</title>
    <link rel="stylesheet" href="style.css">
    <!-- <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDoltFeieAhlFQ_Y7R_aNeJlug7KNfCNNc&callback=initMap">
    </script> -->

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

#map {
    height: 400px;
    width: 100%;
}

@media (max-width: 768px) {
    #map {
        height: 300px;
    }
}
.carousel-image {
    height: 400px; /* Set a fixed height */
    object-fit: cover; /* Ensures images are scaled to cover the area without distorting */
}

</style>

<body>
    <header>
        <nav class="navbar navbar-expand-lg bg-body-tertiary shadow">
            <div class="container-md">
                <a class="navbar-brand" href="#" id="site-title">ONLINE REAL ESTATE ECOMMERCE PLATFORM</a>
                <a href="index.php" class="btn btn-outline-secondary border-0 btn-sm shadow"><i class="bi bi-arrow-left-square"></i> Back</a>
            </div>
        </nav>
    </header>
    <main>
        <div class="container mt-4 mb-4 shadow">
            <?php
                $conn = mysqli_connect("localhost", "root", "", "oreep360");
                $sql = "SELECT * FROM properties WHERE property_id = '$property_id'";
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
            ?>
            <!-- Fetch image and other details -->
            <img class="img-fluid shadow" style="width: 100%;" src="<?php echo htmlspecialchars($row['cover_img']); ?>"
                alt="<?php echo htmlspecialchars($row['cover_img']); ?>">
            <div class="d-flex justify-content-between mt-4">
                <h4><strong><?php echo $row['name'];?></strong></h4>
                <h6><i class="bi bi-geo-alt"></i> <?php echo $row['address'];?></h6>
                <h5><strong>Price: </strong><?php echo $row['price'];?></h5>
            </div>
            <hr>
            <h5><strong>Description: </strong><br><?php echo $row['description'];?></h5>

            <?php
            }
        } else {
            echo "<p>No properties available to show.</p>";
        }
        mysqli_close($conn);
        ?>
            <div class="row mt-5 ">
                <div class="col-sm">
                    <h6><strong>Aminities</strong></h6>
                    <?php
                    $conn = mysqli_connect("localhost", "root", "", "oreep360");
                    if (!$conn) {
                        die("Connection failed: " . mysqli_connect_error());
                    }
                    // fetch specific amenities

                    $query = mysqli_query($conn, "SELECT * FROM `property_amenities` WHERE property_id = '$property_id'");

                    if (!$query) {
                        die("Error in query: " . mysqli_error($conn));
                    }

                    $count = mysqli_num_rows($query);
                    if ($count > 0) {
                        while ($get_aminities = mysqli_fetch_assoc($query)) { ?>
                    <span
                        class="badge rounded-pill text-bg-light shadow p-3"><?php echo htmlspecialchars($get_aminities['name']); ?></span>
                    <?php
                        }
                    } else {
                        echo "No amenities found.";
                    }

                    mysqli_close($conn);
                    ?>

                </div>
                <div class="col shadow p-4">
                    <div>
                        <h6><strong>Contact Agent:</strong></h6>
                        <?php
                        $conn = mysqli_connect("localhost", "root", "", "oreep360");
                        // fetch speficific agent data
                        $querys = mysqli_query($conn, "SELECT * FROM agents WHERE agent_id = '$agent_id'");

                        if ($querys && mysqli_num_rows($querys) > 0) {
                            $get_agent = mysqli_fetch_assoc($querys); 
                        ?>
                            <div class="card shadow-sm border border-0">
                                <div class="card-body ">
                                    <h5 class="card-title"><?php echo htmlspecialchars($get_agent['fullname']); ?></h5>
                                    <p class="card-text">
                                        <?php echo htmlspecialchars($get_agent['contact_no']); ?>
                                    </p>
                                    <p class="card-text">
                                    <strong><?php echo htmlspecialchars($get_agent['1st_verification']); ?></strong>
                                    </p>
                                    <a href="mailto:<?php echo htmlspecialchars($get_agent['email_address']); ?>"
                                        class="btn btn-outline-success btn-sm shadow">
                                        Contact <?php echo htmlspecialchars($get_agent['fullname']); ?>
                                    </a>
                                </div>
                            </div>
                        <?php
                            } else {
                            echo "<p>Agent not found.</p>";
                            }
                        ?>

                    </div>
                </div>

                <div class="row">
                    <div class="col-md">
                        <!-- Display map -->
                        <div id="map" class="mt-5">
                            
                        </div>
                    </div>
                    <div class="col-md">
                        <!-- display carousels -->
                         <div class="mt-5">
                        <?php
                        // Fetch images related to the property
                        $conn = mysqli_connect("localhost", "root", "", "oreep360");
                        $query_images = "SELECT * FROM property_images WHERE property_id = '$property_id'";
                        $result_images = mysqli_query($conn, $query_images);

                        if (mysqli_num_rows($result_images) > 0) {
                            echo '<div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
                                    <div class="carousel-inner">';

                            $active = "active"; // Set first image as active
                            while ($image_row = mysqli_fetch_assoc($result_images)) {
                                echo '<div class="carousel-item ' . $active . '">
                                        <img src="' . substr(htmlspecialchars($image_row['image_path']),3) . '" class="d-block w-100 carousel-image" alt="Property Image">
                                    </div>';
                                $active = ""; // Set remaining images as non-active
                            }

                            echo '</div>
                                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            </div>';
                        } else {
                            echo "<p>No images available for this property.</p>";
                        }

                        mysqli_close($conn);
                        ?>

                         </div>
                    </div>
                </div>

                
            </div>
        </div>

    </main>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDoltFeieAhlFQ_Y7R_aNeJlug7KNfCNNc&callback=initMap">
    </script>
    <script src="bootstrap/js/bootstrap.min.js"></script>


    <script>
    function initMap() {
        var location = {
            lat: <?php echo $latitude; ?>,
            lng: <?php echo $longitude; ?>
        };

        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 15,
            center: location,
            gestureHandling: "auto",
            zoomControl: true,
            mapTypeControl: true,
            streetViewControl: true,
            scaleControl: true,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        });

        var marker = new google.maps.Marker({
            position: location,
            map: map,
            title: "Property Location",
            icon: "https://maps.google.com/mapfiles/kml/shapes/homegardenbusiness.png"
        });

        var infoWindow = new google.maps.InfoWindow({
            content: `<div style="font-size: 14px;">
                        <strong>Property Name:</strong> <?php echo addslashes($getprop['name']); ?><br>
                        <strong>Address:</strong> <?php echo addslashes($getprop['address']); ?><br>
                        <strong>Price:</strong> <?php echo addslashes($getprop['price']); ?><br>
                      </div>`
        });

        marker.addListener("click", function() {
            infoWindow.open(map, marker);
        });

        // Optional: Add traffic and transit layers
        var trafficLayer = new google.maps.TrafficLayer();
        trafficLayer.setMap(map);

        var transitLayer = new google.maps.TransitLayer();
        transitLayer.setMap(map);
    }

    initMap();
    </script>

</body>

</html>