<?php
session_start();

// Include the database connection file
include 'parts/dbConnect.php';

// Fetch a random travel tip from the database
$sql = "SELECT tip FROM traveltips ORDER BY RAND() LIMIT 1";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Error: " . mysqli_error($conn));
}

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $randomTip = $row['tip'];
} else {
    $randomTip = "No travel tips available.";
}

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel ="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <title>Travel Tips</title>

    <style>
        .popup {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ccc;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            z-index: 1000;
        }
    </style>
</head>

<body>

    <!-- Display the pop-up with the random travel tip -->
    <div id="travelTipPopup" class="popup">
        <h3>Travel Tip of the Day</h3>
        <p><?php echo $randomTip; ?></p>
        <button onclick="closePopup()">Close</button>
    </div>

    <script>
        window.onload = function () {
            showPopup();
        };

        function showPopup() {
            document.getElementById('travelTipPopup').style.display = 'block';
        }

        function closePopup() {
            document.getElementById('travelTipPopup').style.display = 'none';
        }
    </script>
</body>

</html>
