<?php
    session_start();
    include 'parts/dbConnect.php';
    if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(isset($_SESSION['email'])){
        if(isset($_GET['followedemail'])){

            $currentUser = $_SESSION['email'];
            $followedUser = $_GET['followedemail'];

            $sql = "INSERT INTO roammates (follower, following) VALUES ('$currentUser', '$followedUser')";
            $result = mysqli_query($conn, $sql);
            if($result){
            $showAlert = true;
            }
        }
    }
}

    header("Location: /Atlas/roammates.php");

?>