<?php
session_start();
include '../parts/dbConnect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $food = $_POST["food"];
    $category = "food";
    $email = $_SESSION["email"];

    // Add the trip name variable
    $tripName = isset($_GET['trip_name']) ? $_GET['trip_name'] : 'Unknown Trip';

    // Select the existing data for the user including the trip name
    $insertQuery = "INSERT INTO budget_tracking (email, category, amount, trip_name) VALUES ('$email', '$category', '$food', '$tripName')";
    $result = $conn->query($insertQuery);

    // Redirect back with the trip name
    $redirect_url = "../budgettracking.php?trip_name=".urlencode($tripName);
    header("Location: $redirect_url");
}
?>
