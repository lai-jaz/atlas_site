
<?php 
    session_start();
    include 'parts/dbConnect.php'; 

    $update = false;
    $showError = false;
    $email =  $_SESSION['email'];

    // set session variable for pfp (added to update as the user changes it)
    $sql = "SELECT profilePic FROM user_profile WHERE email = '$email'"; 
    $result = mysqli_query($conn, $sql);
    $row = $result->fetch_assoc();
    $_SESSION['profilePic'] = $row['profilePic'];

    if($_SERVER["REQUEST_METHOD"] == "POST"){

        // new entered information
        $newfirstName = $_POST["firstName"];
        $newlastName = $_POST["lastName"]; 
        $password = $_POST["password"];

        $sql = "Select * from user_profile where email = '$email' AND password = '$password'";
        $result = mysqli_query($conn, $sql);
        $numrecords = mysqli_num_rows($result); // number of records with matching email

        if($numrecords == 1){   // check if password matches the email
            
                $destination = $_SESSION['profilePic']; // initialize with old pfp

                // uploading image

                if (isset($_FILES["file"]) && $_FILES["file"]["error"] == 0) {
                    // file details
                    $fileName = $_FILES["file"]["name"];
                    $fileType = $_FILES["file"]["type"];
                    $fileSize = $_FILES["file"]["size"];
                    $fileTmpName = $_FILES["file"]["tmp_name"];
                    
                    // specify the directory of uploaded files
                    $uploadDirectory = "pfp/";
            
                    // ensure the directory exists; create it if not
                    if (!is_dir($uploadDirectory)) {
                        mkdir($uploadDirectory, 0755, true);
                    }

                    // move the uploaded file to the specified directory
                    $destination = $uploadDirectory . $fileName;
                    $moved = move_uploaded_file($fileTmpName, $destination);
                }

                $sql = "UPDATE user_profile SET firstName = '$newfirstName', lastName = '$newlastName', profilePic ='$destination' WHERE email = '$email'";
                $result = $conn->query($sql);
                if($result){
                    $update = true;
                    // reset session variables for all
                    // get first name
                    $sql = "SELECT firstName FROM user_profile WHERE email = '$email'"; 
                    $result = mysqli_query($conn, $sql);
                    $row = $result->fetch_assoc();
                    $_SESSION['firstName'] = $row['firstName'];

                 // get last name
                    $sql = "SELECT lastName FROM user_profile WHERE email = '$email'";
                    $result = mysqli_query($conn, $sql);
                    $row = $result->fetch_assoc();
                    $_SESSION['lastName'] = $row['lastName'];

                // get pfp
                    $sql = "SELECT profilePic FROM user_profile WHERE email = '$email'"; 
                    $result = mysqli_query($conn, $sql);
                    $row = $result->fetch_assoc();
                    $_SESSION['profilePic'] = $row['profilePic'];
                }
                else{
                    $showError = "Could not update your profile";
                }   
        } 
        else
        {
            $showError = "Wrong password.";
        }
        
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
    <title>Atlas | Edit Profile</title>      
    </head>
    <body>
    <div class="container-fluid">
    <div class="row">
        
      <!------------------ Sidebar include (1/6th of the page) ---------------->
      <?php include 'parts/sidebar.php'; ?>

      <!----------------------- Main Content bar -------------------------->
      <div class="col-md-10 main-content sidebar">
        <!-- navbar include -->
      <?php include 'parts/navbar.php'; ?>

        <!-- Main content-->

        <div class="post-box">
            <h5 style="font-weight: bold; text-align:center;">Edit your profile</h5>
            <form action="/Atlas/EditProfile.php" method="post" style="font-size: 16px;" enctype="multipart/form-data">
            
                <div class="mx-auto col-10 col-md-8 col-lg-6"> 
                    <div class="mb-3 d-flex justify-content-center align-items-center">
                    <img src="<?php echo  $_SESSION['profilePic'];?>" class="img-thumbnail my-3" 
                        style="display: flex;
                        justify-content: center;
                        align-items: center;
                        border-radius: 50%;
                        height: 20vh;
                        margin: 0;" alt="...">
                    </div>

                    <!-- Upload photo -->
                     <div class="mx-auto col-10 col-md-8 col-lg-6">
                    <label for="file">Change picture:</label>
                    <input type="file" name="file" id="file" accept="image/*">
                    </div>
                </div>

                <div class="mx-auto col-10 col-md-8 col-lg-6">
                    <label for="firstName" class="form-label">First Name</label>
                    <input type="firstName" class="form-control" id="firstName" name="firstName" style="font-size: 16px;"
                    value="<?php if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){
                                echo $_SESSION['firstName'];
                            }?>" >
                </div>

                <div class="mx-auto col-10 col-md-8 col-lg-6">
                    <label for="lastName" class="form-label">Last Name</label>
                    <input type="lastName" class="form-control" id="lastName" name="lastName" style="font-size: 16px;"
                    value="<?php if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){
                                echo $_SESSION['lastName'];
                            }?>" >
                </div>

                <div class="mx-auto col-10 col-md-8 col-lg-6">
                    <label for="email" class="form-label">Email/Username</label>
                    <input type="email" class="form-control" id="email" name="email" style="font-size: 16px;"
                    value="<?php if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){
                                echo $_SESSION['email'];
                            }?>" readonly>
                </div>

                <div class="mx-auto col-10 col-md-8 col-lg-6">
                    <label for="password" class="form-label">Enter your password to confirm</label>
                    <input type="password" class="form-control" id="password" name="password" style="font-size: 16px;">
                </div>

                <div class="btn-primary mx-auto text-center" style="margin-top:1rem;">
                <button type="submit" class="btn btn-light" style="border: 1px solid #fff; background-color: rgb(255, 255, 255, 0.5);">Update Profile</button>
                </div>
            </form>
        </div>
        </div>
    </div>
    </div>
    
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>

</body>

</html>

