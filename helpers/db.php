<?php
// Making connection to SQL database
$conn = mysqli_connect("localhost", "wexford", "Adewale16!", "pizza_parier");

// Checking if connection is valid
if (!$conn) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit();
}
