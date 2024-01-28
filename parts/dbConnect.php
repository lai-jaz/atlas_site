<?php // connecting the database
    $server = "localhost";
    $username = "root";
    $password = "";
    $database = "atlas_site";
    $conn = mysqli_connect($server, $username, $password, $database);

    if(!$conn){
        die("Error".mysqli_connect_error());
    }

?>