<?php
session_start();
include '../parts/dbConnect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $misc = $_POST["misc"];
    $category = "miscellaneous";
    $email = $_SESSION["email"];

    // Add the trip name variable
    $tripName = isset($_GET['trip_name']) ? $_GET['trip_name'] : 'Unknown Trip';

    // Select the existing data for the user including the trip name
    $insertQuery = "INSERT INTO budget_tracking (email, category, amount, trip_name) VALUES ('$email', '$category', '$misc', '$tripName')";
    $result = $conn->query($insertQuery);

    // Redirect back with the trip name
    $redirect_url = "../budgettracking.php?trip_name=".urlencode($tripName);
    header("Location: $redirect_url");
}
?>
