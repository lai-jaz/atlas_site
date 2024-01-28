<?php
    session_start();
    include 'parts/dbConnect.php';
    if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(isset($_SESSION['email'])){
        if(isset($_GET['unfollowedemail'])){

            $currentUser = $_SESSION['email'];
            $unfollowedUser = $_GET['unfollowedemail'];

            $sql = "DELETE FROM roammates WHERE follower = '$currentUser' AND following = '$unfollowedUser';";
            $result = mysqli_query($conn, $sql);
            if($result){
                $showAlert = true;
            }   
        }
    }
}

    header("Location: /Atlas/roammates.php");

?>