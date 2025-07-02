<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $semester = $_POST['semester'];
    $year = $_POST['year'];

    $sql = "INSERT INTO semesters (semester, year) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $semester, $year);

    if ($stmt->execute()) {
        echo "<script>alert('Semester added successfully!'); window.location.href='dashboard.php';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }
}
