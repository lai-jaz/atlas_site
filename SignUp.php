<!-- php code for adding account -->
<?php 
    $showAlert = false;
    $showError = false;
    if($_SERVER["REQUEST_METHOD"] == "POST"){

        include 'parts/dbConnect.php';
        $firstname = $_POST["firstname"];
        $lastname = $_POST["lastname"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $cpassword = $_POST["cpassword"];

        $existsInDb = "SELECT * from `user_profile` WHERE email = '$email'";
        $result = mysqli_query($conn,  $existsInDb);
        $existingRows = mysqli_num_rows($result);   // no of rows that match the entered email address

        if($existingRows > 0){  // check if account already exists
            $showError = " Account already exists";
        }
        else{
            if(($password == $cpassword)){  // check if passwords match
                $sql = "INSERT INTO `user_profile` (`firstName`, `lastName`, `email`, `password`) VALUES ('$firstname', '$lastname', '$email', '$password');";
                $result = mysqli_query($conn, $sql);
                if($result){

                    header("location: Atlas.html");
                }
            }
            else{
                $showError = " Passwords do not match";
            }
        }
  
    }

?>
