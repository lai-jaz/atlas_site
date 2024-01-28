<?php
session_start();
$email = $_SESSION["email"];
$tripName = isset($_GET['trip_name']) ? htmlspecialchars($_GET['trip_name']) : 'Unknown Trip';
$location = isset($_GET['location']) ? htmlspecialchars($_GET['location']) : 'Unknown Location';

include 'parts/dbConnect.php';

function getBudgetAmountForTrip($category, $email, $tripName) {
    global $conn;
    $result = $conn->query("SELECT amount FROM budget_tracking WHERE category = '$category' AND email = '$email' AND trip_name = '$tripName'");
    $row = $result->fetch_assoc();
    return isset($row['amount']) ? $row['amount'] : 0;
}

// Function to get all budget records for a specific category and trip
function getBudgetRecordsForTrip($category, $email, $tripName) {
    global $conn;
    $records = array();
    $result = $conn->query("SELECT * FROM budget_tracking WHERE category = '$category' AND email = '$email' AND trip_name = '$tripName'");
    while ($row = $result->fetch_assoc()) {
        $records[] = $row;
    }
    return $records;
}

// Function to calculate total budget for a specific trip
function getTotalBudgetForTrip($email, $tripName) {
    $accommodation = getBudgetAmountForTrip('accommodation', $email, $tripName);
    $travel = getBudgetAmountForTrip('travel', $email, $tripName);
    $miscellaneous = getBudgetAmountForTrip('miscellaneous', $email, $tripName);
    $food = getBudgetAmountForTrip('food', $email, $tripName);
    return $accommodation + $travel + $miscellaneous + $food;
}

$accommodationRecords = getBudgetRecordsForTrip('accommodation', $email, $tripName);
$travelRecords = getBudgetRecordsForTrip('travel', $email, $tripName);
$miscellaneousRecords = getBudgetRecordsForTrip('miscellaneous', $email, $tripName);
$foodRecords = getBudgetRecordsForTrip('food', $email, $tripName);

$rowCount = max(
    count($accommodationRecords),
    count($travelRecords),
    count($miscellaneousRecords),
    count($foodRecords)
);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="home.css" />
    <link rel="stylesheet" href="budgettracking.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <title>Atlas | Budget Tracking</title>

    <!-- Table styling -->
    <!-- Table styling -->
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 2px solid white;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #add8e6; /* Light blue background color */
        }

        td input {
            width: 100%; /* Make input fields fill the entire cell */
            box-sizing: border-box;
        }

        tbody tr:nth-child(even) {
            background-color: #f9f9f9; /* Add alternate row background color */
        }
    </style>
</head>

<body>
    <div class="container-fluid" style="background-color: #c0ecfc; height:100%;" >
        <div class="row">
            <!-- Sidebar (1/6th of the page) -->
            <?php include 'parts/sidebar.php'?>

            <!-- Main Content (5/6th of the page) -->
            <div class="col-md-10 main-content sidebar">
                <?php include 'parts/navbar.php'?>

                <!-- Main content -->
                <h2>Budget Tracking for Trip: <?php echo $tripName; ?></h2>

                <!-- Your existing HTML content -->
                <div class="container mt-5">
                    <table id="myTable">
                        <thead>
                            <tr>
                                <th>Accommodation</th>
                                <th>Food</th>
                                <th>Miscellaneous</th>
                                <th>Travel</th>
                            </tr>
                        </thead>
                        <tbody> <tr>
                                <td>
                                    <form id="accom" action="budget_manage/accom_budget.php?trip_name=<?php echo $tripName?>" method="post">
                                        <input id="accom" name="accom" type="number" min="0" class="accommodation" required>
                                        <button type="submit" class="btn">Add accommodation</button>
                                    </form>
                                </td>
                                <td>
                                    <form id="food" action="budget_manage/food_budget.php?trip_name=<?php echo $tripName?>" method="post">
                                        <input id="food" name="food" type="number" min="0" class="food" required>
                                        <button type="submit" class="btn">Add food expense</button>
                                    </form>
                                </td>
                                <td>
                                    <form id="misc" action="budget_manage/misc_budget.php?trip_name=<?php echo $tripName?>" method="post">
                                        <input id="misc" name="misc" type="number" min="0" class="misc" required>
                                        <button type="submit" class="btn">Add miscellaneous expense</button>
                                    </form>
                                </td>
                                <td>
                                    <form id="travel" action="budget_manage/travel_budget.php?trip_name=<?php echo $tripName?>" method="post">
                                        <input id="travel" name="travel" type="number" min="0" class="travel" required>
                                        <button type="submit" class="btn">Add travel expense</button>
                                    </form>
                                </td>
                            </tr>
                            <tr>
                                <td>User's budget table: </td>
                            </tr>
                            <tr>
                                <?php
                                $userEmail = $_SESSION["email"];
            
                                // Query to get totals by category for a certain email
                                $sql = "SELECT category, amount FROM budget_tracking WHERE email = '$userEmail' AND trip_name = '$tripName' ORDER BY category";
                                $result = $conn->query($sql);
            
                                // Check if there are results
                                if ($result->num_rows > 0) {
                                    $currentCategory = null;
                                    $categoryTotal = 0;
            
                                    // Display amounts by category
                                    while ($row = $result->fetch_assoc()) {
                                        $category = $row["category"];
                                        $amount = $row["amount"];
            
                                        // Check if the category has changed
                                        if ($category !== $currentCategory) {
                                            // Display the category total if it's not the first iteration
                                            if ($currentCategory !== null) {
                                                echo "Category Total: $" . $categoryTotal . "<br></td>";
                                            }
            
                                            // Display the new category
                                            echo "<td><b>Category: " . $category . "</b><br>";
                                            $currentCategory = $category;
                                            $categoryTotal = 0;
                                        }
            
                                        // Display the amount for the current category
                                        echo "Amount: $" . $amount . "<br>";
            
                                        // Accumulate the category total
                                        $categoryTotal += $amount;
                                    }
            
                                    // Display the last category total
                                    echo "Category Total: $" . $categoryTotal . "<br>";
            
                                } else {
                                    echo "No records found for the specified email.";
                                }
            
                                // Query to get the overall total for a certain email
                                $sqlTotal = "SELECT SUM(amount) AS total FROM budget_tracking WHERE email = '$userEmail' AND trip_name = '$tripName'";
                                $resultTotal = $conn->query($sqlTotal);
            
                                // Check if there are results
                                if ($resultTotal->num_rows > 0) {
                                    // Display the overall total
                                    $rowTotal = $resultTotal->fetch_assoc();
                                    echo "</tr><tr><td>Overall Total: $" . $rowTotal["total"] . "</td></tr>";
                                } else {
                                    echo "No records found for the specified email.";
                                }
                                ?>
                            </tr>
                            <!-- ... (your existing table content) ... -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and Popper.js scripts (required for Bootstrap components) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
