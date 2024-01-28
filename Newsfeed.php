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
    <title>Atlas | Newsfeed</title>      
    </head>
    <body>
    <div class="container-fluid">
    <div class="row">
        
      <!------------------ Sidebar include (1/6th of the page) ---------------->
      <div class="col-md-2 sidebar">
    <img src="\Atlas\Images\atlas logo.png" style="width: 40%; height: auto; margin: 2rem;" />

        <div style="padding:2rem; padding-top:5rem;">
        <div class="profile-images-container">
        <!-- Profile picture -->
        <img src="<?php echo $_SESSION['profilePic']?>" alt="Profile Image" class="profile-image">
        <img src="\Atlas\Images\Outline.png" class="overlapping-image">
        </div>
        <!-- User info -->
        <br><h5 style="font-weight: bold;"><?php echo $_SESSION['firstName'] . ' ' . $_SESSION['lastName']; ?></h5>
        <p><?php echo $_SESSION['email']?></p>
        <a href="roammates.php" class="nav-link"><p style="font-weight: bold; font-size: 1.25rem;">Roammates</p></a>
        <a href="home.php" class="nav-link"><p style="font-weight: bold; font-size: 1.25rem;">Home</p></a>
        </div>

        <!-- travel tip -->
        <!-- Display the pop-up with the random travel tip -->
        <div class="post-box" style="padding:0.75rem; margin-top:-2rem;">
            <?php 
            // code for travel tips
                $sql = "SELECT tip FROM traveltips ORDER BY RAND() LIMIT 1";
                $result = mysqli_query($conn, $sql);

                if (!$result) {
                    die("Error: " . mysqli_error($conn));
                }

                if ($result && mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);
                    $randomTip = $row['tip'];
                } else {
                    $randomTip = "No travel tips available.";
                }
            ?>
            <h5 style="font-weight: bold;">Travel Tip of the Day</h5>
            <p><?php echo $randomTip; ?></p>
        </div>
        
      </div>


      <!----------------------- Main Content bar -------------------------->
      <div class="col-md-10 main-content sidebar">
        <!-- navbar include -->
      <?php include 'parts/navbar.php';  ?>

        <!-- Main content-->

        <!------------------ MEMORIES ------------------------>
        <div id="map-placeholder">
        <div class="post-box-container"><br>
        <h5 style="font-weight: bold;">Memories:</h5>
        <div class="post-box">
            <?php  
  
                $threeMonthsAgo = date('Y-m-d', strtotime('-3 months'));
                
                $threeMonthsAgoMonth = date('m', strtotime($threeMonthsAgo)); // Extract the month and year parts
                $threeMonthsAgoYear = date('Y', strtotime($threeMonthsAgo));
        
                $sql = "SELECT * FROM user_posts WHERE email = '$email' AND
                  (YEAR(created_at) <= $threeMonthsAgoYear AND MONTH(created_at) <= $threeMonthsAgoMonth)";
        
                $today = date('d');
                $result = mysqli_query($conn, $sql);
                if($result)
                {
                  $numrecords = mysqli_num_rows($result);
                  if($numrecords != 0)
                  {
                    echo '<h6 style="font-weight: bold;">Looking back on...</h6>';
                      while ($row = mysqli_fetch_assoc($result)) 
                      {
                          echo '<h6>'. (new DateTime($row['created_at']))->format('F j, Y') .'</h6>';
                          if($row['type'] == "image")
                          {
                              echo $row['title'];
                              echo '<br><br><img src="'. $row['image'].'" style="
                              width: 20vh;
                              height: auto;
                              max-width: 100%;">';
                              echo '<p>'. $row['text'] .'</p>';
                          }
                      }
                  }
                }
             
            ?>
        </div>
        </div>
        </div>

        <!--------- USER POSTS ------------>
        <br>
        <h5 style="font-weight: bold; margin-top:2rem;">Your feed:</h5> <br>
        <?php 
              
              $userEmail = $_SESSION['email'];
              
              // Select posts from users that the logged-in user is following
              $sql = "(SELECT up.*, u.firstName, u.lastName, u.profilePic
              FROM user_posts up
              JOIN user_profile u ON up.email = u.email
              WHERE up.email = '$userEmail')
             UNION
             (SELECT up.*, u.firstName, u.lastName, u.profilePic
              FROM user_posts up
              JOIN roammates r ON up.email = r.following
              JOIN user_profile u ON up.email = u.email
              WHERE r.follower = '$userEmail')
             ORDER BY created_at DESC"; 
              
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
                            <img src="'.$row['profilePic'].'" alt="Profile Picture" class="img-fluid rounded-circle" style="width: 4rem;">
                            </div>
                            <div class="col-md-10" style="margin-left:-6    rem;">
                            <!-- User Info -->
                            <p>'.$row['firstName'] . ' ' . $row['lastName'] .' at <a href="PostMap.php?id='.$row['id'].'" style= "font-weight: bold; text-decoration:none; color:#000">'.$row['location_name'].'</a></p>
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
            else
            {
                echo 'Error: result invalid';
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

  
    <script>
            window.onload = function () {
                showPopup();
            };

            function showPopup() {
                document.getElementById('travelTipPopup').style.display = 'block';
            }

            function closePopup() {
                document.getElementById('travelTipPopup').style.display = 'none';
            }
    </script>

  <!-- Bootstrap JS and Popper.js scripts (required for Bootstrap components) -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>