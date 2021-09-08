<?php

// Connects to label_ordering database.

$servername = "localhost";
$username = "admin";
$password = "Ditch1234!";
$dbname = "label_ordering";

// Create Connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check Connection
if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}

?>