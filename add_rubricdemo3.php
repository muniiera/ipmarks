<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require 'config.php'; // Ensure database connection is included

    $cat_id = "C01"; // This is a string, so use "s"
    $aspect = $_POST['aspect'];
    $verygood = $_POST['verygood'];
    $good = $_POST['good'];
    $fair = $_POST['fair'];
    $weak = $_POST['weak'];
    $weightage = $_POST['weightage']; // Assuming this is a decimal/double

    // Prepare statement with the correct number of placeholders
    $stmt = $conn->prepare("INSERT INTO criteria_demo3 (cat_id, aspect, demo_score1, demo_score2, demo_score3, demo_score4, weightage) 
                            VALUES (?, ?, ?, ?, ?, ?, ?)");

    // Corrected bind_param() -> "ssssssd" (7 parameters)
    $stmt->bind_param("ssssssd", $cat_id, $aspect, $verygood, $good, $fair, $weak, $weightage);

    if ($stmt->execute()) {
        echo "<script>alert('Rubric Demo 3 added successfully'); window.location.href='unit_project.php';</script>";
    } else {
        echo "<script>alert('Error: " . $stmt->error . "'); </script>";
        echo $cat_id, $aspect, $verygood, $good, $fair, $weak, $weightage;
    }

    $stmt->close();
}

$conn->close();
