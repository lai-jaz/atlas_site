<?php
session_start();
include '../parts/dbConnect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $travel = $_POST["travel"];
    $category = "travel";
    $email = $_SESSION["email"];
    $tripName = isset($_GET['trip_name']) ? $_GET['trip_name'] : 'Unknown Trip';// Assuming "tripName" is the name of the GET parameter

    // select the existing data for the user
    $insertQuery = "INSERT INTO budget_tracking (email, category, amount, trip_name) VALUES ('$email', '$category', '$travel', '$tripName')";
    $result = $conn->query($insertQuery);

    // redirect back
    $redirect_url = "../budgettracking.php?trip_name=".urlencode($tripName);
    header("Location: $redirect_url");
}
?>
