<?php
$servername = "localhost"; // Change if needed
$username = "root"; // Change to your MySQL username
$password = "abc123"; // Change to your MySQL password
$dbname = "user_system"; // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
