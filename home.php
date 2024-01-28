<?php
  session_start();
  include 'parts/dbConnect.php';
  $email = $_SESSION['email'];  
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
    <title>Atlas | Home page</title>      
    </head>
    <body>
    <div class="container-fluid" style="background-color: #c0ecfc;">
    <div class="row">
        
      <!------------------ Sidebar include (1/6th of the page) ---------------->
      <?php include 'parts/sidebar.php';?>


      <!----------------------- Main Content bar -------------------------->
      <div class="col-md-10 main-content sidebar">
        <!-- navbar include -->
      <?php include 'parts/navbar.php';  ?>

        <!-- Main content-->

        <!------------------ MAP ------------------------>
        <h5 style="font-weight: bold;">Pinned Locations:</h5>
        <div id="map">
        <div id="map-placeholder">
        <?php 
        
          $sql = "SELECT * FROM user_posts WHERE email= '$email'";
          $result = mysqli_query($conn, $sql);

          $locations = array();

          while ($row = $result->fetch_assoc()) {
          $locations[] = array(
          "name" => $row['location_name'],
          "lat" => $row['latitude'],
          "lng" => $row['longitude'],
          );
          }

          // Convert the locations array into a json object
          $locations_json = json_encode($locations);

          if (json_last_error()) {
          echo "JSON encode error: " . json_last_error_msg();
          exit();
        }
      ?>


        </div>
        </div>
        <div>
            <br>
        <h5 style="font-weight: bold;">Got something to share?</h5>
        </div>

        <!---------- POST BOX --------------->
        <div class="post-box">
        <div class="profile-section">
          <img class="profile-picture" src="<?php echo $_SESSION['profilePic']?>" alt="Profile Picture">
          <div class="profile-info">
            <p>Where are you heading now, <?php echo $_SESSION['firstName']; ?>?</p>
          </div>
        </div>
        <div class="post-buttons">
          <form  action="textpost.php">
          <button class="post-button">Write a New post</button>
          </form>
          <form  action="imagepost.php">
          <button class="post-button">Upload Photo</button>
          </form>
          <form  action="reviewpost.php">
          <button class="post-button">Add a Review</button>
          </form>
        
        </div>
        </div>

        <!--------- USER POSTS ------------>
        <br>
        <h5 style="font-weight: bold;">Your posts:</h5> <br>
        <?php 
              
              $email = $_SESSION['email'];    

              // Build and execute the SQL query
              $sql = "SELECT * FROM user_posts WHERE email = '$email' ORDER BY created_at DESC";
              $result = mysqli_query($conn, $sql);
              
              if($result)
              {
                $numrecords = mysqli_num_rows($result);
                if($numrecords != 0)
                {
                  while ($row = mysqli_fetch_assoc($result)) 
                  {
                        echo '<div class="container post-container" style="    border-radius: 15px; border: 2px solid #fff;">
                        <div class="row">
                            <div class="col-md-2" style="padding-right:2rem;">
                            <!-- Profile Picture -->
                            <img src="'.$_SESSION['profilePic'].'" alt="Profile Picture" class="img-fluid rounded-circle" style="width: 4rem;">
                            </div>
                            <div class="col-md-10" style="margin-left:-6    rem;">
                            <!-- User Info -->
                            <p>'.$_SESSION['firstName'] . ' ' . $_SESSION['lastName'] .' at <a href="PostMap.php?id='.$row['id'].'" style= "font-weight: bold; text-decoration:none; color:#000">'.$row['location_name'].'</a></p>
                            </div>
                        </div>
                        <div class="row">
                            <!-- Post Title -->
                            <p class="post-title">'.$row['title'].'</p>';
                    
                    if($row['type'] == "review")
                    {
                        echo '<div style="display:flex;">';
                        $j = 1;
                        while($j<=$row['rating'] && $j<=5){
                            echo '<span class="fa fa-star checked" style="color: #d9b1a2; font-size: 20px"></span>';
                            $j++;
                        }
                        while($j<=5){
                            echo '<span class="fa fa-star" style="color: #132035; font-size: 20px"></span>';
                            $j++;
                        }
                        echo '</div>';
                    }

                        echo '<!-- Post Caption -->
                            <p class="post-caption">'.$row['text'].'</p>';

                    if($row['type'] == "image" || $row['type'] == "review")
                    {
                        echo ' <!-- Post Image -->
                            <img src="'.$row['image'].'" alt="Post Image" 
                            style="width: 50%;">';
                    }
                    echo '</div>';
                    echo '  <!-- Heart Icon -->
                        <br><div class="row"><img src="Images/like_comment.png" alt="Heart Icon" class="heart-icon" style="width:4rem;">
                        </div>
                        </div>';
                  }
                }
            } 
        ?>
            
 

    </div>
    </div>
    </div>

    
  <!-- JS Section -->
  <script>
    var map = L.map('map').setView([0, 0], 2);
    var markerGroup = L.layerGroup().addTo(map);
    var locations = <?= $locations_json ?>;

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    function addMarkers(locations) {
      locations.forEach(function(location) {
        var marker = L.marker([location.lat, location.lng], { title: location.name }).addTo(markerGroup);
        marker.bindPopup(location.name);
      });
    }
    
    addMarkers(locations);
  </script>

  <!-- Bootstrap JS and Popper.js scripts (required for Bootstrap components) -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>