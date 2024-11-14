<?php
// Database connection details
$servername = "localhost";
// Determine if the server is localhost
if ($_SERVER['SERVER_NAME'] == 'localhost') {
    $username = "root";
    $password = "";
    $dbname = "drakrtripuramindcareandpolyclinic";
} else {
    $username = "drakrtripuramind";
    $password = "9rTHaMUNGyUaaW1";
    $dbname = "drakrtripuramindcareandpolyclinic";
    
}

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
