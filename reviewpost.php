<!-- php code for adding image post -->
<?php 
    session_start();

    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        include 'parts/dbConnect.php';

        // other information of post
        $title = $_POST["title"];
        $text = $_POST["text"];
        $email =  $_SESSION['email'];
        $destination = false;
        $locationName = mysqli_real_escape_string($conn, $_POST['location_name']);
        $latitude = mysqli_real_escape_string($conn, $_POST['latitude']);
        $longitude = mysqli_real_escape_string($conn, $_POST['longitude']);
        // uploading image

        if (isset($_FILES["file"]) && $_FILES["file"]["error"] == 0) {
            // file details
            $fileName = $_FILES["file"]["name"];
            $fileType = $_FILES["file"]["type"];
            $fileSize = $_FILES["file"]["size"];
            $rating = $_POST["rating"];
            $fileTmpName = $_FILES["file"]["tmp_name"];
            
            // specify the directory of uploaded files
            $uploadDirectory = "uploads/";
    
            // ensure the directory exists; create it if not
            if (!is_dir($uploadDirectory)) {
                mkdir($uploadDirectory, 0755, true);
            }

            // move the uploaded file to the specified directory
            $destination = $uploadDirectory . $fileName;
            $moved = move_uploaded_file($fileTmpName, $destination);
        }

        $sql = "INSERT INTO user_posts (type, title, text, image, rating, likes, email, location_name, latitude, longitude) VALUES ('review', '$title', '$text', '$destination', '$rating', 0, '$email', '$locationName', '$latitude', '$longitude')";
        $result = mysqli_query($conn, $sql);
    }
?>
<!DOCTYPE html>
<html>
    <head>
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="home.css"/>
    <link rel ="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder@1.13.0/dist/Control.Geocoder.css" />
    <script src="https://unpkg.com/leaflet-control-geocoder@1.13.0/dist/Control.Geocoder.js"></script>
    <style>
        #map {
            height: 400px;
            width: 100%;
        }
    </style>
     <script>
         // js function to update the displayed value
         document.addEventListener('DOMContentLoaded', function() {
            var slider = document.getElementById('rating');
            var sliderValue = document.getElementById('sliderValue');

            slider.addEventListener('input', function() {
                sliderValue.textContent = slider.value;
            });
        });
    </script>
    <title>Atlas | New Review Post</title>      
    </head>
    <body>

    <div class="container-fluid" style="background-color: #c0ecfc;">
    <div class="row">
        
      <!------------------ Sidebar include (1/6th of the page) ---------------->
      <?php include 'parts/sidebar.php'; ?>


      <!----------------------- Main Content bar -------------------------->
      <div class="col-md-10 main-content sidebar">
        <!-- navbar include -->
      <?php include 'parts/navbar.php'; ?>

        <!-- Main content-->

        <div class="post-box">
            <h5 style="font-weight: bold; text-align:center;">Upload a Review</h5>
            <form action="/Atlas/reviewpost.php" method="post" style="font-size: 16px;" enctype="multipart/form-data">
                <div class="mx-auto col-10 col-md-8 col-lg-6">
                    <label for="title" class="form-label">Title:</label>
                    <input type="title" class="form-control" id="title" name="title" pstyle="font-size: 16px;">
                    
                </div>

                <div class="mx-auto col-10 col-md-8 col-lg-6">
                    <label for="file">Select a picture:</label>
                    <input type="file" name="file" id="file" accept="image/*">
                </div>

                <!-- Adding star rating -->
                <div class="mx-auto col-10 col-md-8 col-lg-6">
                    <label for="rating">Rate:</label>
                    <input type="range" id="rating" name="rating" min="0" max="5" step="1" value="3">
                    <span id="sliderValue">3</span>
                </div>

                <div class="mx-auto col-10 col-md-8 col-lg-6">
                    <label for="text" class="form-label">Caption:</label>
                    <input type="text" class="form-control" id="text" name="text" style="font-size: 16px;">
                </div>
                <div class="mx-auto col-10 col-md-8 col-lg-6 text-center">

                <!-- Geotagging Section -->
                <div class="mx-auto col-10 col-md-8 col-lg-6">
                    Enter the location of your post:<br>
                    <label for="location_name">Location:</label>
                    <input type="text" id="location_name" name="location_name" placeholder="Enter a location">
                    <input type="hidden" id="latitude" name="latitude">
                    <input type="hidden" id="longitude" name="longitude">
                    <button type="button" onclick="geotagLocation()">Pin Location</button>
                </div>

                Search location from the following map:<br>
                <div id="map"></div>

                <div class="btn-primary mx-auto text-center" style="margin-top:1rem;">
                <button type="submit" class="btn btn-light" style="border: 1px solid #fff; background-color: rgb(255, 255, 255, 0.5);">Submit Post</button>
                </div>
                </div>
            </form>
        </div>
        </div>
    </div>
    </div>

    
  <!-- JS Section -->
  <script>
        var map = L.map('map').setView([0, 0], 2);
        var markerGroup = L.layerGroup().addTo(map);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        var geocoder = L.Control.geocoder({
            geocoder: L.Control.Geocoder.nominatim()
        }).addTo(map);

        function addMarker(location, title) {
            var marker = L.marker(location, { title: title }).addTo(markerGroup);
        }

        geocoder.on('markgeocode', function (e) {
            var markerPosition = e.geocode.center;
            document.getElementById('latitude').value = markerPosition.lat;
            document.getElementById('longitude').value = markerPosition.lng;
            addMarker(markerPosition, document.getElementById('location_name').value);
        });

        function geotagLocation() {
            var locationInput = document.getElementById('location_name').value;
            geocoder.geocode(locationInput);
        }
    </script>

  <!-- Bootstrap JS and Popper.js scripts (required for Bootstrap components) -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>
</html>