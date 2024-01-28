<?php
// Include your database connection file
include 'parts/dbConnect.php';

// Retrieve values from the form
$locationName = mysqli_real_escape_string($conn, $_POST['location_name']);
$latitude = mysqli_real_escape_string($conn, $_POST['latitude']);
$longitude = mysqli_real_escape_string($conn, $_POST['longitude']);

// Insert the values into your database table
$sql = "INSERT INTO geotagged_locations (location_name, latitude, longitude) VALUES ('$locationName', '$latitude', '$longitude')";
$result = mysqli_query($conn, $sql);

// Handle the result (you may want to add more error checking)
if ($result) {
    echo "Location saved successfully.";
} else {
    echo "Error: " . mysqli_error($conn);
}

// Close the database connection
mysqli_close($conn);
?>
