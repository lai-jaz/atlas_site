<!-- php code for logging in to the account -->
<?php 
    $login = false;
    $showError = false;
    if($_SERVER["REQUEST_METHOD"] == "POST"){

        include 'parts/dbConnect.php';
        $email = $_POST["email"];
        $password = $_POST["password"];

        $sql = "Select * from user_profile where email = '$email' AND password = '$password'";
        $result = mysqli_query($conn, $sql);
        $numrecords = mysqli_num_rows($result); // number of records with matching email

        if($numrecords == 1){   // check if account exists
                $login = true;
                session_start();
                $_SESSION['loggedin'] = true;
                $_SESSION['email'] = $email;

                // get profile picture
                $sql = "SELECT profilePic FROM user_profile WHERE email = '$email'"; 
                $result = mysqli_query($conn, $sql);
                $row = $result->fetch_assoc();
                $_SESSION['profilePic'] = $row['profilePic'];
         
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

                header("location: home.php");
            }
        else{
            $showError = " Account not found.";
        }
    }
?>

