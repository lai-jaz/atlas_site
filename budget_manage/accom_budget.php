<?php
session_start();
include '../parts/dbConnect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $accom = $_POST["accom"];
    $category = "accommodation";
    $email = $_SESSION["email"];

    // Add the trip name variable
    $tripName = isset($_GET['trip_name']) ? $_GET['trip_name'] : 'Unknown Trip';

    // select the existing data for the user
    $insertQuery = "INSERT INTO budget_tracking (email, category, amount, trip_name) VALUES ('$email', '$category', '$accom', '$tripName')";
    $result = $conn->query($insertQuery);

    // redirect back
    $redirect_url = "../budgettracking.php?trip_name=".urlencode($tripName); // Include trip name in the redirect URL
    header("Location: $redirect_url");
}
?>
