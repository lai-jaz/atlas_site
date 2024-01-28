<?php
session_start();
include 'parts/dbConnect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $location = mysqli_real_escape_string($conn, $_POST['location']);
    $tripName = mysqli_real_escape_string($conn, $_POST['trip_name']);
    $userEmail = $_SESSION["email"];

    // Insert trip information into the trips table
    $sql = "INSERT INTO trips (location, trip_name, email) VALUES ('$location', '$tripName', '$userEmail')";
    
    if ($conn->query($sql) === TRUE) {
        // Get the ID of the inserted trip
        $tripId = $conn->insert_id;

        // Redirect to the budget tracking page for the specific trip with trip name and location
        header("Location: budgettracking.php?trip_name=" . urlencode($tripName));
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="plan.css" />
    <link rel="stylesheet" href="home.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <title>ATLAS | Plan a Trip</title>
</head>
<body>
<div class="container-fluid" style="min-height: 100%; 
    width: 100%;
    background-color: #c0ecfc;
    box-sizing: border-box;">
        <div class="row">
            <!-- Sidebar (1/6th of the page) -->
            <?php include 'parts/sidebar.php'?>

            <!-- Main Content (5/6th of the page) -->
            <div class="col-md-10 main-content sidebar">
                <?php include 'parts/navbar.php'?>              

<div class="plan-a-trip">
    <div class="form-container">
        <h1>Plan a Trip</h1>
        <form id="tripForm" action="plan.php" method="post">
            <label for="location">Location:</label>
            <input type="text" id="location" name="location" required>

            <label for="tripName">Trip Name:</label>
            <input type="text" id="tripName" name="trip_name" required>

            <button type="submit" class="orange-button">Add plan</button>
        </form>
    </div>
            <div class="overlap-4">
              <img class="img" />
              <div class="text-wrapper-9">Gwadar Beach</div>
              <img class="ph-calendar" />
            </div>
            <div class="overlap-5">
              <img class="imgKhoj" />
              <div class="text-wrapper-9">Khoj Resorts</div>
              <img class="ph-calendar-2"  />
            </div>
            <div class="overlap-6">
              <img class="rectangle-2" />
              <div class="text-wrapper-9">PC Bhurbhan</div>
              <img class="ph-calendar-2" />
            </div>
            <div class="overlap-7">
              <img class="rectangle-3" />
              <div class="text-wrapper-10">Mabali Island</div>
              <img class="ph-calendar-3"/>
            </div>
          </div>  
</div>
   

</body>
</html>
