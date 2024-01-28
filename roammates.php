<?php
session_start();
include 'parts/dbConnect.php';

// Validate and sanitize user inputs (example)
function sanitize($data) {
    global $conn;
    return mysqli_real_escape_string($conn, htmlspecialchars($data));
}

$email = sanitize($_SESSION['email']);
$query = "SELECT * FROM roammates
          JOIN user_profile ON roammates.following = user_profile.email
          WHERE roammates.follower = '$email'";

$result = mysqli_query($conn, $query);

$showAlert = false;
$showError = false;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css"> <!-- Add your custom styles here -->
    <link rel="stylesheet" href="home.css"/>
    <link rel ="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link rel="stylesheet" href="roammates.css">
    <title>ATLAS | Roammates</title>
</head>

<body>

    <div class="container-fluid">
        <div class="row">

            <!-- Sidebar (1/6th of the page) -->
            <?php include 'parts/sidebar.php';?>

            <!-- Main Content (5/6th of the page) -->
            <div class="col-md-10 main-content sidebar">
                
                <title>ATLAS | Roammates</title>
                <?php include 'parts/navbar.php';?>
                <!-- Display followed users -->
                <section class="roammates">
                    <div class="container">
                        <h1 class="text-center" style="font-size: 30px; color: #132035;">Roammates</h1>

                        <?php
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo '<div class="roammate-card">';
                                echo '<img src="' . $row['profilePic'] . '" class="img-thumbnail my-3 profile-image-r" alt="Profile Image"> </span>';
                                echo '<div class="roammate-info">';
                                echo '<p class="username">Username: ' . $row['email'] . '</p>';
                                echo '<p class="name">Name: ' . $row['firstName'] . ' ' . $row['lastName'] . '</p>';
                                echo '</div>';
                                echo '<div class="unfollow-button">';
                                $friendemail = $row['email'];
                                $unfollowAction = '/Atlas/unfollowuser.php?unfollowedemail=' . $friendemail;
                                echo '<form action="' . $unfollowAction . '" method="post" style="font-size: 16px;">';
                                echo '<button type="submit" class="btn btn-danger">Unfollow</button>';
                                echo '</form>';
                                echo '</div>';
                                echo '</div>';
                            }
                        } else {
                            echo '<p class="text-center">No roammates found.</p>';
                        }
                        ?>
                    </div>
                    <div class="container">
                    <h1 class="text-center" style="font-size: 30px; color: #132035;">All Users</h1>
                    <?php
                        $email = $_SESSION['email'];
                        $query = "SELECT * FROM user_profile WHERE email != '$email'";
                        $result = mysqli_query($conn, $query);
                
                        if ($result) {
                            while ($row = mysqli_fetch_assoc($result)) 
                            {
                                echo '<div class="roammate-card">
                               <img src="' . $row['profilePic'] . '" class="img-thumbnail my-3 profile-image-r" alt="Profile Image"> </span>
                                <div class="roammate-info">
                                <p class="username">Username: ' . $row['email'] . '</p>
                                <p class="name">Name: ' . $row['firstName'] . ' ' . $row['lastName'] . '</p>
                                </div>
                                <div></div>';
                                $friendemail = $row['email'];
                
                                $sql = "SELECT * FROM roammates WHERE (follower = '$email' AND following = '$friendemail')";
                                $resultFollow = mysqli_query($conn, $sql);
                
                                    $numrecords = mysqli_num_rows($resultFollow);
                                    
                                    if($numrecords == 0)
                                    {   
                                        echo '<form action="/Atlas/followuser.php?followedemail='. $row['email'] .'" method="post" style="font-size: 16px;">';
                                        echo '<button type="submit" class="btn btn-danger">Follow</button>';
                                    }
                                    else
                                    {
                                        echo '<form action="/Atlas/unfollowuser.php?unfollowedemail='. $row['email'] .'" method="post" style="font-size: 16px;">';
                                        echo '<button type="submit" class="btn btn-danger">Unfollow</button>';
                                    }
                                echo '</div> </form>';
                            }
                        }
                
                    ?>
                    </div>
                </section>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and Popper.js scripts (required for Bootstrap components) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>

